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
use Illuminate\Support\Facades\Mail;

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
        $feePercent = 7.9 / 100;
        $fixedFee = 1;
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
                // app()->environment('local', 'testing'),
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
                Log::warning('Payment success data missing', [
                    'payment_intent_id' => $paymentIntentId,
                    'trip_id' => $tripId
                ]);

                return view('mobile.auth.done', [
                    'error' => 'بيانات الدفع غير مكتملة',
                    'orderNumber' => null
                ]);
            }

            $trip = Trip::find($tripId);
            if (!$trip) {
                return view('mobile.auth.done', [
                    'error' => 'لم يتم العثور على الرحلة المطلوبة',
                    'orderNumber' => null
                ]);
            }

            $user = auth()->user();
            if (!$user) {
                return view('mobile.auth.done', [
                    'error' => 'المستخدم غير مسجل الدخول',
                    'orderNumber' => null
                ]);
            }

            $ziinaHandler = new ZiinaPaymentHandler();
            $paymentIntent = $ziinaHandler->getPaymentIntent($paymentIntentId);

            Log::info('Payment intent fetched', [
                'payment_intent' => $paymentIntent
            ]);

            if (!isset($paymentIntent['status']) || $paymentIntent['status'] !== 'completed') {
                return view('mobile.auth.done', [
                    'error' => 'لم يتم تأكيد الدفع بعد، برجاء المحاولة لاحقاً.',
                    'orderNumber' => null
                ]);
            }

            return DB::transaction(function () use ($trip, $user, $paymentIntent, $paymentIntentId) {
                // تحقق لو فيه حجز موجود بالفعل
                $existingBooking = Booking::where('payment_intent_id', $paymentIntentId)->first();
                if ($existingBooking) {
                    return view('mobile.auth.done', [
                        'success' => 'تم تأكيد الحجز مسبقاً، رقم الطلب: ' . $existingBooking->order_number,
                        'booking' => $existingBooking,
                        'trip' => $trip,
                        'orderNumber' => $existingBooking->order_number
                    ]);
                }

                $pendingBooking = session('pending_booking', []);
                $roomType = $paymentIntent['metadata']['room_type'] ?? $pendingBooking['room_type'] ?? 'shared';

                // ✅ احسب السعر الأساسي
                $basePrice = $this->calculateTripPrice($trip, $roomType);

                // ✅ احسب رسوم بوابة الدفع
                $feePercent = 7.9 / 100;
                $fixedFee = 1;
                $paymentGatewayFee = ($basePrice * $feePercent) + $fixedFee;

                // ✅ السعر النهائي (شامل الرسوم)
                $totalPrice = $basePrice + $paymentGatewayFee;

                // ✅ أنشئ رقم طلب فريد
                $orderNumber = 'REF' . mt_rand(10000000, 99999999);

                // ✅ أنشئ الحجز
                $booking = Booking::create([
                    'trip_id' => $trip->id,
                    'user_id' => $user->id,
                    'booking_date' => now(),
                    'order_type' => $roomType === 'shared' ? 'غرفة مشتركة' : 'غرفة خاصة',
                    'destination' => $trip->title_ar ?? $trip->title ?? 'وجهة الرحلة',
                    'customer_name' => $user->name,
                    'status' => 'confirmed',
                    'amount' => $totalPrice, // شامل الرسوم
                    'payment_gateway_fee' => $paymentGatewayFee, // ✅ خزّن الرسوم هنا
                    'payment_intent_id' => $paymentIntentId,
                    'payment_status' => 'paid',
                    'payment_data' => json_encode($paymentIntent),
                    'order_number' => $orderNumber,
                ]);

                if (isset($trip->current_participants)) {
                    $trip->increment('current_participants');
                }

                try {
                    Mail::send('emails.success', [
                        'booking' => $booking,
                        'trip' => $trip,
                        'user' => $user
                    ], function ($message) use ($user, $orderNumber) {
                        $message->to($user->email)
                            ->subject("عمدة الصين - فاتورة رقم {$orderNumber}");
                    });
                } catch (\Exception $mailException) {
                    Log::error('Failed to send booking email', [
                        'order_number' => $orderNumber,
                        'error' => $mailException->getMessage()
                    ]);
                }

                session()->forget(['pending_booking', 'selected_room_type']);

                return view('mobile.auth.done', [
                    'success' => 'تم حجز الرحلة بنجاح! رقم الطلب: ' . $orderNumber,
                    'booking' => $booking,
                    'trip' => $trip,
                    'orderNumber' => $orderNumber
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Payment success handling failed', [
                'payment_intent_id' => $request->get('payment_intent_id'),
                'trip_id' => $request->get('trip_id'),
                'error' => $e->getMessage()
            ]);

            return view('mobile.auth.done', [
                'error' => 'حدث خطأ في التحقق من الدفع: ' . $e->getMessage(),
                'orderNumber' => null
            ]);
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
