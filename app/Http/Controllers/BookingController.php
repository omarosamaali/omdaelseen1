<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\User;
use App\Services\ZiinaPaymentHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Exception;

class BookingController extends Controller
{
    public function initiatePayment(Request $request, $id)
    {
        try {
            $trip = Trip::findOrFail($id);

            $roomType = $request->input('room_type') ?? $request->query('room_type') ?? session('selected_room_type', 'shared');
            $totalPrice = $request->input('total_price') ?? $request->query('total_price');

            if (!$totalPrice) {
                $basePrice = $this->calculateTripPrice($trip, $roomType);
                $feePercent = 0.029;
                $totalPrice = $basePrice * (1 + $feePercent);
            }

            $paymentHandler = new ZiinaPaymentHandler();
            $successUrl = route('booking.payment.success');
            $cancelUrl = route('booking.payment.cancel');

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
                return redirect()->route('mobile.auth.done')
                    ->with('error', 'بيانات الدفع غير مكتملة');
            }

            $ziinaHandler = new ZiinaPaymentHandler();
            $paymentIntent = $ziinaHandler->getPaymentIntent($paymentIntentId);

            if ($paymentIntent['status'] === 'completed') {
                return DB::transaction(function () use ($tripId, $paymentIntentId, $paymentIntent) {
                    $trip = Trip::findOrFail($tripId);
                    $user = auth()->user();

                    if (!$user) {
                        Log::error('User not authenticated', [
                            'payment_intent_id' => $paymentIntentId,
                            'trip_id' => $tripId
                        ]);
                        return redirect()->route('mobile.auth.done')
                            ->with('error', 'المستخدم غير مسجل الدخول');
                    }

                    $existingBooking = Booking::where('payment_intent_id', $paymentIntentId)->first();
                    if ($existingBooking) {
                        Log::info('Booking already exists for payment intent', [
                            'payment_intent_id' => $paymentIntentId,
                            'booking_id' => $existingBooking->id
                        ]);
                        return redirect()->route('mobile.auth.done')
                            ->with('success', 'تم تأكيد الحجز مسبقاً، رقم الطلب: ' . $existingBooking->order_number);
                    }

                    $pendingBooking = session('pending_booking');
                    $roomType = $paymentIntent['metadata']['room_type'] ?? $pendingBooking['room_type'] ?? 'shared';
                    $totalPrice = $pendingBooking['total_price'] ?? $paymentIntent['metadata']['final_price_with_fees'] ?? null;

                    if (!$totalPrice) {
                        $basePrice = $this->calculateTripPrice($trip, $roomType);
                        $totalPrice = $basePrice * (1 + 0.029);
                    }

                    // توليد رقم طلب مميز
                    $orderNumber = 'TRIP-' . now()->format('Ymd') . '-' . Str::random(6);

                    // تخزين الحجز في جدول bookings
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

                    // إرسال إيميل للأدمن
                    $this->sendAdminNotification($booking, $trip, $user);

                    // إرسال إيميل للمستخدم
                    $this->sendUserConfirmation($booking, $trip, $user);

                    session()->forget(['pending_booking', 'selected_room_type']);

                    Log::info('Booking created successfully', [
                        'booking_id' => $booking->id,
                        'order_number' => $orderNumber,
                        'trip_id' => $tripId,
                        'user_id' => $user->id,
                        'amount' => $totalPrice,
                        'room_type' => $roomType
                    ]);

                    return redirect()->route('mobile.auth.done')
                        ->with('success', 'تم حجز الرحلة بنجاح! رقم الطلب: ' . $orderNumber);
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

    /**
     * إرسال إشعار للأدمن بحجز جديد
     */
    private function sendAdminNotification($booking, $trip, $user)
    {
        try {
            // جلب إيميلات الأدمن (يمكن تعديلها حسب احتياجك)
            $adminEmails = User::where('role', 'admin')->pluck('email')->toArray();

            // إذا لم يكن هناك أدمن، استخدم إيميل افتراضي
            if (empty($adminEmails)) {
                $adminEmails = [config('mail.admin_email', 'admin@chinaomda.com')];
            }

            $roomTypeText = $booking->order_type;

            foreach ($adminEmails as $adminEmail) {
                Mail::send('emails.admin_new_booking', [
                    'orderNumber' => $booking->order_number,
                    'customerName' => $user->name,
                    'customerEmail' => $user->email,
                    'customerPhone' => $user->phone ?? $user->mobile ?? 'غير متوفر',
                    'tripTitle' => $trip->title_ar ?? $trip->title,
                    'roomType' => $roomTypeText,
                    'amount' => $booking->amount,
                    'bookingDate' => $booking->booking_date->format('Y-m-d H:i'),
                    'bookingUrl' => url('/admin/bookings/' . $booking->id)
                ], function ($message) use ($adminEmail, $booking) {
                    $message->to($adminEmail)
                        ->subject('🎉 مشترك جديد - طلب رقم: ' . $booking->order_number);
                });
            }

            Log::info('Admin notification sent', [
                'booking_id' => $booking->id,
                'admin_emails' => $adminEmails
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send admin notification', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال تأكيد الحجز للمستخدم
     */
    private function sendUserConfirmation($booking, $trip, $user)
    {
        try {
            $roomTypeText = $booking->order_type;

            Mail::send('emails.user_booking_confirmation', [
                'customerName' => $user->name,
                'orderNumber' => $booking->order_number,
                'tripTitle' => $trip->title_ar ?? $trip->title,
                'roomType' => $roomTypeText,
                'amount' => $booking->amount,
                'bookingDate' => $booking->booking_date->format('Y-m-d H:i'),
                'tripUrl' => url('mobile/info_place/' . $trip->id)
            ], function ($message) use ($user, $booking) {
                $message->to($user->email)
                    ->subject('✅ تأكيد حجز الرحلة - طلب رقم: ' . $booking->order_number);
            });

            Log::info('User confirmation sent', [
                'booking_id' => $booking->id,
                'user_email' => $user->email
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send user confirmation', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
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
}
