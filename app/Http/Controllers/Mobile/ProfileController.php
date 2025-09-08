<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // تأكد من استيراد Storage
use Illuminate\Support\Facades\Log; // تأكد من استيراد Log

class ProfileController extends Controller
{
    public function sendOtp(Request $request)
    {
        $user = Auth::user();

        // توليد رمز OTP مكون من 4 أرقام
        $otp = rand(1000, 9999);

        // حفظ الرمز في قاعدة البيانات أو الجلسة (Session)
        // للحفاظ على بساطة المثال، سنستخدم الجلسة
        $request->session()->put('otp', $otp);

        // إرسال الرمز عبر البريد الإلكتروني
        Mail::to($user->email)->send(new OtpMail($otp));

        // إعادة توجيه المستخدم إلى صفحة التحقق
        return redirect()->route('mobile.profile.verify');
    }

    public function verifyOtp(Request $request)
    {
        // التحقق من أن الرمز المدخل يطابق الرمز المخزن
        if ($request->input('otp') == $request->session()->get('otp')) {
            // حذف الرمز من الجلسة
            $request->session()->forget('otp');

            // تحديث حالة المستخدم إلى "موثق" في قاعدة البيانات
            $user = Auth::user();
            $user->is_verified = true; // افترض أن لديك حقل is_verified في جدول users
            $user->save();

            // إعادة توجيه المستخدم إلى صفحة النجاح
            return redirect()->route('mobile.profile.success');
        } else {
            // إعادة توجيه مع رسالة خطأ
            return redirect()->back()->withErrors(['otp' => 'الرمز غير صحيح.']);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'explorer_name' => ['nullable', 'string', 'max:255', 'unique:users,explorer_name,' . $user->id],
        ]);

        $data = $request->except(['password', 'password_confirmation', '_token']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        // 4. Redirect with a success message
        return redirect()->route('mobile.profile.profile')->with('success', 'تم تحديث ملفك الشخصي بنجاح!');
    }

    // You can also add a delete method for the "حذف الحساب" button

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        try {
            // Log the user out to prevent issues after deletion
            Auth::logout();

            // Delete the user's avatar from storage if it exists
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            // Delete the user from the database
            $user->delete();

            // Redirect the user to the home page with a success message
            return redirect('/')->with('success', 'تم حذف حسابك بنجاح.');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Account deletion failed for user ' . $user->id . ': ' . $e->getMessage());

            // Redirect back with an error message
            return back()->with('error', 'حدث خطأ أثناء حذف الحساب. يرجى المحاولة مرة أخرى.');
        }
    }
}
