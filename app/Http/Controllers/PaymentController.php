<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ZiinaPaymentHandler;
use App\Models\Payment;
use App\Models\Adds;

class PaymentController extends Controller
{
    public function startPayment(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $amount  = $request->input('amount');

            $order = Adds::findOrFail($orderId);

            // ✅ لو السعر 0 أو الطلب مجاني
            if ($order->price == 0) {
                Payment::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'order_type' => 'adds',
                    'amount' => 0,
                    'currency' => 'AED',
                    'payment_reference' => null,
                    'status' => 'free',
                    'gateway_response' => null,
                    'reference_number' => 'REF' . rand(1000000000, 9999999999),
                ]);

                $order->update(['status' => 'requested']);

                return redirect()->route('mobile.welcome')
                    ->with('success', 'تم إرسال الطلب بنجاح ✅ (بدون دفع)');
            }

            // ✅ لو السعر > 0، نكمل الدفع عادي
            $trip = new \stdClass();
            $trip->id = $order->id;
            $trip->price = $order->price;
            $trip->title_ar = $order->type_ar;

            $paymentService = new ZiinaPaymentHandler();
            $successUrl = route('payment.callback');
            $cancelUrl  = url()->previous();

            $response = $paymentService->createTripPaymentIntent(
                $trip,
                $successUrl,
                $cancelUrl,
                app()->environment('local'),
                $amount,
                'standard'
            );

            if (isset($response['redirect_url'])) {
                // ✅ خزن الـ payment_intent_id اللي هيرجع في الـ callback
                $paymentReference = $response['payment_intent_id']
                    ?? $response['payment_reference']
                    ?? $response['id']
                    ?? null;

                Payment::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'order_type' => 'adds',
                    'amount' => $amount,
                    'currency' => 'AED',
                    'payment_reference' => $paymentReference,
                    'status' => 'pending',
                    'gateway_response' => json_encode($response),
                    'reference_number' => 'REF' . rand(1000000000, 9999999999),

                ]);

                Log::info('Payment created', [
                    'order_id' => $order->id,
                    'payment_reference' => $paymentReference,
                    'amount' => $amount
                ]);

                return redirect()->away($response['redirect_url']);
            }

            Log::error('Ziina returned invalid response', ['response' => $response]);
            return back()->with('error', 'تعذّر بدء عملية الدفع.');
        } catch (\Exception $e) {
            Log::error('Redirect to Ziina failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء بدء عملية الدفع.');
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Ziina callback received', [
                'method' => $request->method(),
                'all_data' => $data,
            ]);

            // ✅ استخرج الـ payment_intent_id و invoice_id من Ziina
            $paymentIntentId = $data['payment_intent_id'] ?? null;
            $invoiceId = $data['invoice_id'] ?? null;

            // ✅ حاول تستخرج الـ status من أي مكان متاح
            $status = $data['status'] ?? $data['payment_status'] ?? 'success';

            Log::info('Extracted values', [
                'payment_intent_id' => $paymentIntentId,
                'invoice_id' => $invoiceId,
                'status' => $status
            ]);

            if (!$paymentIntentId) {
                Log::error('Payment intent ID not found in callback', ['data' => $data]);
                return redirect()->route('mobile.welcome')
                    ->with('error', 'معلومات الدفع غير مكتملة.');
            }

            // ✅ ابحث بالـ payment_intent_id
            $payment = Payment::where('payment_reference', $paymentIntentId)
                ->where('order_type', 'adds')
                ->first();

            // ✅ لو مش لاقيه، جرب تدور بالـ invoice_id (order_id)
            if (!$payment && $invoiceId) {
                $payment = Payment::where('order_id', $invoiceId)
                    ->where('order_type', 'adds')
                    ->where('status', 'pending')
                    ->latest()
                    ->first();

                Log::info('Payment found by invoice_id', [
                    'payment_id' => $payment ? $payment->id : null
                ]);
            }

            if (!$payment) {
                Log::error('Payment not found', [
                    'payment_intent_id' => $paymentIntentId,
                    'invoice_id' => $invoiceId
                ]);
                return redirect()->route('mobile.welcome')
                    ->with('error', 'طلب الدفع غير موجود.');
            }

            // ✅ اجلب الطلب
            $order = Adds::find($payment->order_id);

            if (!$order) {
                Log::error('Order not found', ['order_id' => $payment->order_id]);
                return redirect()->route('mobile.welcome')
                    ->with('error', 'الطلب غير موجود.');
            }

            $payment->update([
                'status' => 'paid',
                'payment_reference' => $paymentIntentId, // تأكد من حفظ الـ ID الصحيح
                'gateway_response' => json_encode($data)
            ]);

            // تحديث الطلب
            $order->update(['status' => 'paid']);

            Log::info('Payment successful', [
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntentId
            ]);

            return redirect()->route('mobile.welcome')
                ->with('success', 'تم الدفع بنجاح 🎉');
        } catch (\Exception $e) {
            Log::error('Ziina callback handling failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->route('mobile.welcome')
                ->with('error', 'حدث خطأ أثناء معالجة عملية الدفع.');
        }
    }
}
