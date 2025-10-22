<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ZiinaPaymentHandler;
use App\Models\Payment;
use App\Models\Adds;

class PaymentController extends Controller
{
    /**
     * بدء عملية الدفع عبر Ziina
     */
    public function startPayment(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $amount  = $request->input('amount');

            $order = Adds::findOrFail($orderId);

            // مثال لو مفيش علاقة بـ Trip
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
                Payment::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'order_type' => 'adds',
                    'amount' => $amount,
                    'currency' => 'AED',
                    'payment_reference' => $response['payment_reference'] ?? null,
                    'status' => 'paid',
                    'gateway_response' => json_encode($response),
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

    /**
     * رد Ziina بعد الدفع (Callback)
     */
    public function handleCallback(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('Ziina callback received', $data);
            $status = $data['status'] ?? null;
            $paymentRef = $data['payment_reference'] ?? null;
            $order = Adds::where('payment_reference', $paymentRef)->first();
            if (!$order) {
                return redirect()->route('mobile.welcome')->with('error', 'طلب الدفع غير موجود.');
            }
            if ($status === 'success' || $status === 'paid') {
                $order->update(['status' => 'paid']);
                return redirect()->route('mobile.welcome')->with('success', 'تم الدفع بنجاح 🎉');
            } else {
                $order->update(['status' => 'failed']);
                return redirect()->route('mobile.welcome')->with('error', 'فشلت عملية الدفع ❌');
            }
        } catch (\Exception $e) {
            Log::error('Ziina callback handling failed', ['error' => $e->getMessage()]);
            return redirect()->route('mobile.welcome')->with('error', 'حدث خطأ أثناء معالجة عملية الدفع.');
        }
    }
}
