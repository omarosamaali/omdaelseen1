<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripBooking;
use App\Services\ZiinaPaymentHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class TripController extends Controller
{
    public function initiatePayment(Request $request, $id)
    {
        try {
            $trip = Trip::findOrFail($id);

            // الحصول على نوع الغرفة والسعر النهائي من الـ request أو session
            $roomType = $request->input('room_type') ?? $request->query('room_type') ?? session('selected_room_type', 'shared');
            $totalPrice = $request->input('total_price') ?? $request->query('total_price');

            // إذا لم يكن السعر موجود، احسبه مع الرسوم
            if (!$totalPrice) {
                $basePrice = $this->calculateTripPrice($trip, $roomType);
                $feePercent = 0.029; // 2.9%
                $totalPrice = $basePrice * (1 + $feePercent);
            }

            $paymentHandler = new ZiinaPaymentHandler();
            $successUrl = route('trip.payment.success');
            $cancelUrl = route('trip.payment.cancel');

            Log::info('Initiating payment with calculated price', [
                'trip_id' => $id,
                'room_type' => $roomType,
                'base_price' => $this->calculateTripPrice($trip, $roomType),
                'total_price_with_fees' => $totalPrice
            ]);

            $response = $paymentHandler->createTripPaymentIntent(
                $trip,
                $successUrl,
                $cancelUrl,
                app()->environment('local', 'testing'), // test mode للتطوير
                $totalPrice,  // ✅ السعر النهائي شامل الرسوم
                $roomType     // نوع الغرفة
            );

            // حفظ معلومات الحجز مؤقتاً
            session([
                'pending_booking' => [
                    'trip_id' => $trip->id,
                    'user_id' => auth()->id(),
                    'room_type' => $roomType,
                    'total_price' => $totalPrice,
                    'payment_intent_id' => $response['id'] ?? null
                ]
            ]);

            // توجيه المستخدم لصفحة الدفع
            return redirect()->away($response['redirect_url']);
        } catch (\Exception $e) {
            Log::error('Failed to initiate payment', [
                'trip_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'حدث خطأ في عملية الدفع. يرجى المحاولة مرة أخرى.');
        }
    }

    /**
     * ✅ دالة لحساب سعر الرحلة حسب نوع الغرفة
     */
    private function calculateTripPrice($trip, $roomType = null)
    {
        // إذا كان هناك أسعار مختلفة للغرف
        if ($trip->private_room_price && $roomType) {
            switch ($roomType) {
                case 'shared':
                    return $trip->shared_room_price ?? $trip->price;
                case 'private':
                    return $trip->private_room_price;
                default:
                    return $trip->price;
            }
        }

        // إذا لم يكن هناك تقسيم للغرف، استخدم السعر الأساسي
        return $trip->price;
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $paymentIntentId = $request->get('payment_intent_id');
            $tripId = $request->get('trip_id');

            if (!$paymentIntentId || !$tripId) {
                Log::warning('Incomplete payment success data', [
                    'payment_intent_id' => $paymentIntentId,
                    'trip_id' => $tripId
                ]);
                return redirect()->route('mobile.auth.done' )
                    ->with('error', 'بيانات الدفع غير مكتملة');
            }

            $ziinaHandler = new ZiinaPaymentHandler();
            $paymentIntent = $ziinaHandler->getPaymentIntent($paymentIntentId);

            if ($paymentIntent['status'] === 'completed') {
                return DB::transaction(function () use ($tripId, $paymentIntentId, $paymentIntent) {
                    $trip = Trip::findOrFail($tripId);

                    $existingBooking = TripBooking::where('payment_intent_id', $paymentIntentId)->first();
                    if ($existingBooking) {
                        Log::info('Booking already exists for payment intent', [
                            'payment_intent_id' => $paymentIntentId,
                            'booking_id' => $existingBooking->id
                        ]);
                        return redirect()->route('mobile.auth.done', ['trip' => $trip->id])
                            ->with('success', 'تم تأكيد الحجز مسبقاً');
                    }

                    // استخراج البيانات من session أو metadata
                    $pendingBooking = session('pending_booking');
                    $roomType = $paymentIntent['metadata']['room_type'] ?? $pendingBooking['room_type'] ?? 'shared';

                    // استخدام السعر النهائي من session أو metadata
                    $totalPrice = $pendingBooking['total_price'] ?? $paymentIntent['metadata']['final_price_with_fees'] ?? null;

                    // إذا لم يكن السعر موجود، احسبه مع الرسوم
                    if (!$totalPrice) {
                        $basePrice = $this->calculateTripPrice($trip, $roomType);
                        $totalPrice = $basePrice * (1 + 0.029);
                    }

                    $booking = TripBooking::create([
                        'trip_id' => $tripId,
                        'user_id' => auth()->id(),
                        'payment_intent_id' => $paymentIntentId,
                        'amount' => $totalPrice, // السعر النهائي شامل الرسوم
                        'room_type' => $roomType,
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => 'ziina',
                        'booking_date' => now(),
                        'payment_data' => json_encode($paymentIntent)
                    ]);

                    if (isset($trip->current_participants)) {
                        $trip->increment('current_participants');
                    }

                    // مسح البيانات المؤقتة
                    session()->forget(['pending_booking', 'selected_room_type']);

                    Log::info('Trip booking created successfully', [
                        'booking_id' => $booking->id,
                        'trip_id' => $tripId,
                        'user_id' => auth()->id(),
                        'amount' => $totalPrice,
                        'room_type' => $roomType
                    ]);

                    return redirect()->route('mobile.auth.done', ['trip' => $trip->id])
                        ->with('success', 'تم حجز الرحلة بنجاح!');
                });
            } elseif ($paymentIntent['status'] === 'pending') {
                Log::info('Payment still pending', [
                    'payment_intent_id' => $paymentIntentId,
                    'trip_id' => $tripId
                ]);
                return redirect()->route('trips.show', $tripId)
                    ->with('warning', 'الدفع قيد المعالجة. سيتم تأكيد الحجز قريباً');
            } elseif ($paymentIntent['status'] === 'failed') {
                $errorMessage = $paymentIntent['latest_error']['message'] ?? 'فشل في عملية الدفع';

                Log::warning('Payment failed', [
                    'payment_intent_id' => $paymentIntentId,
                    'error' => $errorMessage
                ]);

                return redirect()->route('trips.show', $tripId)
                    ->with('error', 'فشل في عملية الدفع: ' . $errorMessage);
            } else {
                Log::warning('Unknown payment status', [
                    'payment_intent_id' => $paymentIntentId,
                    'status' => $paymentIntent['status']
                ]);

                return redirect()->route('trips.show', $tripId)
                    ->with('warning', 'حالة الدفع غير واضحة. يرجى التواصل مع الدعم الفني');
            }
        } catch (Exception $e) {
            Log::error('Payment success handling failed', [
                'payment_intent_id' => $request->get('payment_intent_id'),
                'trip_id' => $request->get('trip_id'),
                'error' => $e->getMessage()
            ]);

            return redirect()->route('mobile.auth.done')
                ->with('error', 'حدث خطأ في التحقق من الدفع: ' . $e->getMessage());
        }
    }

    public function paymentCancel(Request $request)
    {
        $tripId = $request->get('trip_id');

        Log::info('Payment cancelled', [
            'trip_id' => $tripId,
            'user_id' => auth()->id()
        ]);

        if ($tripId) {
            return redirect()->route('trips.show', $tripId)
                ->with('warning', 'تم إلغاء عملية الدفع');
        }

        return redirect()->route('mobile.auth.done')
            ->with('warning', 'تم إلغاء عملية الدفع');
    }

    private function isTripAvailable($trip)
    {
        if (!$trip) {
            return [
                'available' => false,
                'reason' => 'الرحلة غير موجودة'
            ];
        }

        if (!isset($trip->price) || $trip->price <= 0) {
            return [
                'available' => false,
                'reason' => 'سعر الرحلة غير محدد أو غير صالح'
            ];
        }

        if (isset($trip->is_active) && !$trip->is_active) {
            return [
                'available' => false,
                'reason' => 'الرحلة غير نشطة'
            ];
        }

        if (isset($trip->start_date) && $trip->start_date) {
            try {
                $startDate = \Carbon\Carbon::parse($trip->start_date);
                if ($startDate->isPast()) {
                    return [
                        'available' => false,
                        'reason' => 'الرحلة قد بدأت بالفعل'
                    ];
                }
            } catch (Exception $e) {
                Log::warning('Invalid start_date format', [
                    'start_date' => $trip->start_date,
                    'error' => $e->getMessage()
                ]);
            }
        }

        if (isset($trip->max_participants) && isset($trip->current_participants)) {
            if ($trip->current_participants >= $trip->max_participants) {
                return [
                    'available' => false,
                    'reason' => 'الرحلة مكتملة العدد'
                ];
            }
        }

        return [
            'available' => true,
            'reason' => 'متاحة للحجز'
        ];
    }

    public function webhook(Request $request)
    {
        try {
            $payload = $request->getContent();
            $signature = $request->header('X-Ziina-Signature');

            $ziinaHandler = new ZiinaPaymentHandler();

            if (!$ziinaHandler->validateWebhook($payload, $signature)) {
                Log::warning('Invalid webhook signature');
                return response('Unauthorized', 401);
            }

            $data = json_decode($payload, true);

            switch ($data['type'] ?? '') {
                case 'payment_intent.succeeded':
                    $this->handlePaymentSucceeded($data);
                    break;

                case 'payment_intent.failed':
                    $this->handlePaymentFailed($data);
                    break;
            }

            return response('OK', 200);
        } catch (Exception $e) {
            Log::error('Webhook handling failed', [
                'error' => $e->getMessage()
            ]);

            return response('Internal Server Error', 500);
        }
    }

    private function handlePaymentSucceeded($data)
    {
        Log::info('Payment succeeded webhook received', $data);
    }

    private function handlePaymentFailed($data)
    {
        Log::info('Payment failed webhook received', $data);
    }

    public function debugTrip($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $availability = $this->isTripAvailable($trip);

        return response()->json([
            'trip_data' => $trip->toArray(),
            'availability' => $availability,
            'user_authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'prices' => [
                'base_price' => $trip->price,
                'shared_room_price' => $trip->shared_room_price,
                'private_room_price' => $trip->private_room_price
            ]
        ]);
    }
}
