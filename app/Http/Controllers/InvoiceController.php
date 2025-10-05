<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZiinaPaymentHandler;
use App\Models\Invoice;
use App\Models\TripRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePaidAdmin;
use App\Mail\InvoicePaidUser;
use App\Models\User; // أضفها في أعلى الملف

class InvoiceController extends Controller
{
    public function initiatePayment(Request $request, $invoiceId)
    {
        try {
            Log::info('بدء عملية الدفع', ['invoice_id' => $invoiceId, 'user_id' => auth()->id()]);

            $invoice = Invoice::findOrFail($invoiceId);

            if ($invoice->status === 'paid') {
                return back()->with('error', 'هذه الفاتورة مدفوعة بالفعل');
            }

            $ziinaHandler = new ZiinaPaymentHandler();

            // حساب رسوم البوابة
            $feePercent = 7.9 / 100; // نسبة العمولة
            $fixedFee = 1; // الرسوم الثابتة
            $finalAmount = ($invoice->amount * (1 + $feePercent)) + $fixedFee;

            Log::info('حساب الرسوم', [
                'base_amount' => $invoice->amount,
                'fee_percent' => $feePercent,
                'fixed_fee' => $fixedFee,
                'final_amount' => $finalAmount
            ]);

            // إنشاء كائن بيانات الفاتورة بعد إضافة الرسوم
            $invoiceData = (object)[
                'id' => $invoice->id,
                'title' => $invoice->title,
                'title_ar' => $invoice->title,
                'price' => $finalAmount
            ];

            $successUrl = route('mobile.invoice.payment.success');
            $cancelUrl = route('mobile.invoice.payment.cancel');

            $paymentIntent = $ziinaHandler->createTripPaymentIntent(
                $invoiceData,
                $successUrl,
                $cancelUrl,
                app()->environment('local'),
                $finalAmount
            );

            // حفظ payment_intent_id في الفاتورة
            $invoice->update([
                'payment_intent_id' => $paymentIntent['id'] ?? null
            ]);

            return redirect($paymentIntent['redirect_url']);
        } catch (\Exception $e) {
            Log::error('فشل إنشاء عملية الدفع', [
                'invoice_id' => $invoiceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'حدث خطأ أثناء إنشاء عملية الدفع: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $paymentIntentId = $request->get('payment_intent_id');
            $invoiceId = $request->get('invoice_id');

            if (!$paymentIntentId) {
                return redirect()->route('mobile.welcome')
                    ->with('error', 'معلومات الدفع غير موجودة');
            }

            $ziinaHandler = new ZiinaPaymentHandler();
            $paymentIntent = $ziinaHandler->getPaymentIntent($paymentIntentId);
            Log::info('تم الوصول إلى دالة paymentSuccess', $request->all());

            // ابحث عن الفاتورة
            $invoice = Invoice::where('payment_intent_id', $paymentIntentId)->first();

            if (!$invoice) {
                return redirect()->route('mobile.welcome')
                    ->with('error', 'الفاتورة غير موجودة');
            }

            // تحديث حالة الفاتورة
            if (isset($paymentIntent['status']) && in_array($paymentIntent['status'], ['paid', 'completed', 'succeeded'])) {
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'paid_by' => auth()->id(), // ✅ تسجيل المستخدم اللي دفع فعلاً
                ]);

                // إرسال إيميل للمستخدم
                try {
                    $payer = $invoice->payer ?? auth()->user(); // علاقة نعرفها تحت

                    if ($payer && $payer->email) {
                        Mail::to($payer->email)->send(new InvoicePaidUser($invoice));
                        Log::info('تم إرسال إيميل للدافع', ['payer_email' => $payer->email]);
                    }
                } catch (\Exception $e) {
                    Log::error('فشل إرسال إيميل للمستخدم', ['error' => $e->getMessage()]);
                }

                // إرسال إيميل للأدمن
                try {
                    $admins = User::where('role', 'admin')->whereNotNull('email')->get();

                    foreach ($admins as $admin) {
                        Mail::to($admin->email)->send(new InvoicePaidAdmin($invoice));
                        Log::info('تم إرسال إيميل لأدمن', ['admin_email' => $admin->email]);
                    }
                } catch (\Exception $e) {
                    Log::error('فشل إرسال إيميل للأدمن', ['error' => $e->getMessage()]);
                }

                // الرجوع لصفحة الفاتورة - استخدم product_id من الفاتورة
                if ($invoice->product_id) {
                    return redirect()->route('mobile.profile.actions.invoice.show', [
                        'id' => $invoice->product_id,
                        'invoice' => $invoice->id
                    ])->with('success', 'تم الدفع بنجاح! شكراً لك.');
                }

                return redirect()->route('mobile.welcome')
                    ->with('success', 'تم الدفع بنجاح! شكراً لك.');
            }

            // إذا كانت الفاتورة قيد المعالجة
            if ($invoice->product_id) {
                return redirect()->route('mobile.profile.actions.invoice.show', [
                    'id' => $invoice->product_id,
                    'invoice' => $invoice->id
                ])->with('warning', 'الدفع قيد المعالجة');
            }

            return redirect()->route('mobile.welcome')
                ->with('warning', 'الدفع قيد المعالجة');
        } catch (\Exception $e) {
            Log::error('خطأ في معالجة نجاح الدفع', [
                'error' => $e->getMessage()
            ]);

            return redirect()->route('mobile.welcome')
                ->with('error', 'حدث خطأ أثناء معالجة الدفع');
        }
    }

    public function paymentCancel(Request $request)
    {
        $invoiceId = $request->get('invoice_id');

        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);

            if ($invoice && $invoice->product_id) {
                return redirect()->route('mobile.profile.actions.invoice.show', [
                    'id' => $invoice->product_id,
                    'invoice' => $invoice->id
                ])->with('info', 'تم إلغاء عملية الدفع');
            }
        }

        return redirect()->route('mobile.welcome')
            ->with('info', 'تم إلغاء عملية الدفع');
    }
}
