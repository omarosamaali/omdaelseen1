<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Booking; // تغيير من TripBooking إلى Booking
use App\Services\ZiinaPaymentHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class TripController extends Controller
{
    private function calculateTripPrice($trip, $roomType = null)
    {
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
        return $trip->price;
    }
    private function calculateFinalPriceWithFees($basePrice)
    {
        $feePercent = 7.9 / 100; // 7.9%
        $fixedFee = 1; // 1 درهم ثابتة
        return ($basePrice * (1 + $feePercent)) + $fixedFee;
    }

    public function initiatePayment(Request $request, $id)
    {
        try {
            $trip = Trip::findOrFail($id);

            $roomType = $request->input('room_type') ?? $request->query('room_type') ?? session('selected_room_type', 'shared');
            $totalPrice = $request->input('total_price') ?? $request->query('total_price');

            if (!$totalPrice) {
                $basePrice = $this->calculateTripPrice($trip, $roomType);
                $totalPrice = $this->calculateFinalPriceWithFees($basePrice);
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
                false,
                $totalPrice,
                $roomType
            );

            session([
                'pending_booking' => [
                    'trip_id' => $trip->id,
                    'user_id' => auth()->id(),
                    'room_type' => $roomType,
                    'total_price' => $totalPrice,
                    'payment_intent_id' => $response['id'] ?? null
                ]
            ]);

            return redirect()->away($response['redirect_url']);
        } catch (\Exception $e) {
            Log::error('Failed to initiate payment', [
                'trip_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'حدث خطأ في عملية الدفع. يرجى المحاولة مرة أخرى.');
        }
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
                return view('mobile.auth.done')
                    ->with('error', 'بيانات الدفع غير مكتملة')
                    ->with('orderNumber', null);
            }

            $ziinaHandler = new ZiinaPaymentHandler();
            $paymentIntent = $ziinaHandler->getPaymentIntent($paymentIntentId);

            Log::info('Payment intent response', [
                'payment_intent' => $paymentIntent
            ]);

            if ($paymentIntent['status'] === 'completed') {
                return DB::transaction(function () use ($tripId, $paymentIntentId, $paymentIntent) {
                    $trip = Trip::findOrFail($tripId);
                    $user = auth()->user();

                    if (!$user) {
                        Log::error('User not authenticated', [
                            'payment_intent_id' => $paymentIntentId,
                            'trip_id' => $tripId
                        ]);
                        return view('mobile.auth.done')
                            ->with('error', 'المستخدم غير مسجل الدخول')
                            ->with('orderNumber', null);
                    }

                    // لو الحجز موجود بالفعل نرجع نفس رقم الطلب
                    $existingBooking = Booking::where('payment_intent_id', $paymentIntentId)->first();
                    if ($existingBooking) {
                        return view('mobile.auth.done')
                            ->with('success', 'تم تأكيد الحجز مسبقاً، رقم الطلب: ' . $existingBooking->order_number)
                            ->with('booking', $existingBooking)
                            ->with('trip', $trip)
                            ->with('orderNumber', $existingBooking->order_number);
                    }

                    $pendingBooking = session('pending_booking');
                    $roomType = $paymentIntent['metadata']['room_type'] ?? $pendingBooking['room_type'] ?? 'shared';
                    $totalPrice = $pendingBooking['total_price'] ?? $paymentIntent['metadata']['final_price_with_fees'] ?? null;

                    if (!$totalPrice) {
                        $basePrice = $this->calculateTripPrice($trip, $roomType);
                        $totalPrice = $this->calculateFinalPriceWithFees($basePrice);
                    }

                    $orderNumber = 'REF' . mt_rand(10000000, 99999999);

                    $booking = Booking::create([
                        'trip_id' => $tripId,
                        'user_id' => $user->id,
                        'booking_date' => now(),
                        'order_type' => $roomType === 'shared' ? 'غرفة مشتركة' : 'غرفة خاصة',
                        'destination' => $trip->title_ar ?? $trip->title ?? 'وجهة الرحلة',
                        'customer_name' => $user->name,
                        'status' => 'confirmed',
                        'amount' => $totalPrice,
                        'payment_intent_id' => $paymentIntentId,
                        'payment_status' => 'paid',
                        'payment_data' => json_encode($paymentIntent),
                        'order_number' => $orderNumber,
                    ]);

                    if (isset($trip->current_participants)) {
                        $trip->increment('current_participants');
                    }

                    session()->forget(['pending_booking', 'selected_room_type']);

                    return view('mobile.auth.done')
                        ->with('success', 'تم حجز الرحلة بنجاح! رقم الطلب: ' . $orderNumber)
                        ->with('booking', $booking)
                        ->with('trip', $trip)
                        ->with('orderNumber', $orderNumber);
                });
            }

            // باقي حالات الدفع نفس الكود الموجود عندك..
        } catch (Exception $e) {
            Log::error('Payment success handling failed', [
                'payment_intent_id' => $request->get('payment_intent_id'),
                'trip_id' => $request->get('trip_id'),
                'error' => $e->getMessage()
            ]);
            return view('mobile.auth.done')
                ->with('error', 'حدث خطأ في التحقق من الدفع: ' . $e->getMessage())
                ->with('orderNumber', null);
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
