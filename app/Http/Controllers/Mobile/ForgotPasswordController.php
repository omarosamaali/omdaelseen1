<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash; // تأكد من إضافة هذا السطر

class ForgotPasswordController extends Controller
{
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    /*******  f2999f49-8d98-448e-8cc9-d7bccce56114  *******/    public function sendResetLink(Request $request)
    {
        // التحقق من صحة البريد الإلكتروني المدخل
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.exists' => 'لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $otp = mt_rand(100000, 999999); // إنشاء رمز OTP مكون من 6 أرقام

        // حفظ الرمز في قاعدة البيانات مع البريد الإلكتروني
        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $otp,
            'created_at' => Carbon::now()
        ]);

        // إرسال البريد الإلكتروني
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
            $message->to($email);
            $message->subject('رمز التحقق لإعادة تعيين كلمة المرور');
        });

        // إعادة التوجيه إلى صفحة إدخال الـ OTP مع تمرير البريد الإلكتروني
        return redirect()->route('mobile.auth.otp-verification')->with('email', $email);
    }
    public function verifyOtp(Request $request)
    {
        // استلام قيمة الـ OTP مباشرة من الحقل
        $otp = $request->otp;
        $email = $request->email;

        // التحقق من صحة الرمز في قاعدة البيانات
        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $otp)
            ->first();

        if (!$record) {
            return redirect()->back()->withErrors(['otp' => 'رمز التحقق غير صحيح أو منتهي الصلاحية.'])->withInput();
        }

        // إذا كان الرمز صحيحًا، يتم حذف السجل من قاعدة البيانات وتوجيه المستخدم لصفحة إنشاء كلمة المرور
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('mobile.auth.create-password')->with('email', $email);
    }



    public function updatePassword(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.exists' => 'المستخدم غير موجود.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل.',
            'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقين.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // تحديث كلمة المرور في قاعدة البيانات
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // إعادة التوجيه إلى صفحة النجاح
        return redirect()->route('mobile.auth.password-reset-successfully');
    }
}
