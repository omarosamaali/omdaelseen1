<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = [
            'AF' => 'أفغانستان',
            'AL' => 'ألبانيا',
            'DZ' => 'الجزائر',
            'AD' => 'أندورا',
            'AO' => 'أنغولا',
            'AG' => 'أنتيغوا وباربودا',
            'AR' => 'الأرجنتين',
            'AM' => 'أرمينيا',
            'AU' => 'أستراليا',
            'AT' => 'النمسا',
            'AZ' => 'أذربيجان',
            'BS' => 'البهاما',
            'BH' => 'البحرين',
            'BD' => 'بنغلاديش',
            'BB' => 'باربادوس',
            'BY' => 'بيلاروسيا',
            'BE' => 'بلجيكا',
            'BZ' => 'بليز',
            'BJ' => 'بنين',
            'BT' => 'بوتان',
            'BO' => 'بوليفيا',
            'BA' => 'البوسنة والهرسك',
            'BW' => 'بوتسوانا',
            'BR' => 'البرازيل',
            'BN' => 'بروناي',
            'BG' => 'بلغاريا',
            'BF' => 'بوركينا فاسو',
            'BI' => 'بوروندي',
            'CV' => 'الرأس الأخضر',
            'KH' => 'كمبوديا',
            'CM' => 'الكاميرون',
            'CA' => 'كندا',
            'CF' => 'جمهورية أفريقيا الوسطى',
            'TD' => 'تشاد',
            'CL' => 'تشيلي',
            'CN' => 'الصين',
            'CO' => 'كولومبيا',
            'KM' => 'جزر القمر',
            'CG' => 'الكونغو',
            'CD' => 'جمهورية الكونغو الديمقراطية',
            'CR' => 'كوستاريكا',
            'HR' => 'كرواتيا',
            'CU' => 'كوبا',
            'CY' => 'قبرص',
            'CZ' => 'التشيك',
            'DK' => 'الدنمارك',
            'DJ' => 'جيبوتي',
            'DM' => 'دومينيكا',
            'DO' => 'جمهورية الدومينيكان',
            'EC' => 'الإكوادور',
            'EG' => 'مصر',
            'SV' => 'السلفادور',
            'GQ' => 'غينيا الاستوائية',
            'ER' => 'إريتريا',
            'EE' => 'إستونيا',
            'SZ' => 'إسواتيني',
            'ET' => 'إثيوبيا',
            'FJ' => 'فيجي',
            'FI' => 'فنلندا',
            'FR' => 'فرنسا',
            'GA' => 'الغابون',
            'GM' => 'غامبيا',
            'GE' => 'جورجيا',
            'DE' => 'ألمانيا',
            'GH' => 'غانا',
            'GR' => 'اليونان',
            'GD' => 'غرينادا',
            'GT' => 'غواتيمالا',
            'GN' => 'غينيا',
            'GW' => 'غينيا بيساو',
            'GY' => 'غيانا',
            'HT' => 'هايتي',
            'HN' => 'هندوراس',
            'HU' => 'المجر',
            'IS' => 'آيسلندا',
            'IN' => 'الهند',
            'ID' => 'إندونيسيا',
            'IR' => 'إيران',
            'IQ' => 'العراق',
            'IE' => 'أيرلندا',
            'IL' => 'إسرائيل',
            'IT' => 'إيطاليا',
            'JM' => 'جامايكا',
            'JP' => 'اليابان',
            'JO' => 'الأردن',
            'KZ' => 'كازاخستان',
            'KE' => 'كينيا',
            'KI' => 'كيريباتي',
            'KP' => 'كوريا الشمالية',
            'KR' => 'كوريا الجنوبية',
            'KW' => 'الكويت',
            'KG' => 'قيرغيزستان',
            'LA' => 'لاوس',
            'LV' => 'لاتفيا',
            'LB' => 'لبنان',
            'LS' => 'ليسotho',
            'LR' => 'ليبيريا',
            'LY' => 'ليبيا',
            'LI' => 'ليختنشتاين',
            'LT' => 'ليتوانيا',
            'LU' => 'لوكسمبورغ',
            'MG' => 'مدغشقر',
            'MW' => 'مالاوي',
            'MY' => 'ماليزيا',
            'MV' => 'جزر المالديف',
            'ML' => 'مالي',
            'MT' => 'مالطا',
            'MH' => 'جزر مارشال',
            'MR' => 'موريتانيا',
            'MU' => 'موريشيوس',
            'MX' => 'المكسيك',
            'FM' => 'ميكرونيزيا',
            'MD' => 'مولدوفا',
            'MC' => 'موناكو',
            'MN' => 'منغوليا',
            'ME' => 'الجبل الأسود',
            'MA' => 'المغرب',
            'MZ' => 'موزمبيق',
            'MM' => 'ميانمار',
            'NA' => 'ناميبيا',
            'NR' => 'ناورو',
            'NP' => 'نيبال',
            'NL' => 'هولندا',
            'NZ' => 'نيوزيلندا',
            'NI' => 'نيكاراغوا',
            'NE' => 'النيجر',
            'NG' => 'نيجيريا',
            'NO' => 'النرويج',
            'OM' => 'عمان',
            'PK' => 'باكستان',
            'PW' => 'بالاو',
            'PA' => 'بنما',
            'PG' => 'بابوا غينيا الجديدة',
            'PY' => 'باراغواي',
            'PE' => 'بيرو',
            'PH' => 'الفلبين',
            'PL' => 'بولندا',
            'PT' => 'البرتغال',
            'QA' => 'قطر',
            'RO' => 'رومانيا',
            'RU' => 'روسيا',
            'RW' => 'رواندا',
            'KN' => 'سانت كيتس ونيفيس',
            'LC' => 'سانت لوسيا',
            'VC' => 'سانت فينسنت والغرينادين',
            'WS' => 'ساموا',
            'SM' => 'سان مارينو',
            'ST' => 'ساو تومي وبرينسيب',
            'SA' => 'السعودية',
            'SN' => 'السنغال',
            'RS' => 'صربيا',
            'SC' => 'سيشل',
            'SL' => 'سيراليون',
            'SG' => 'سنغافورة',
            'SK' => 'سلوفاكيا',
            'SI' => 'سلوفينيا',
            'SB' => 'جزر سليمان',
            'SO' => 'الصومال',
            'ZA' => 'جنوب أفريقيا',
            'SS' => 'جنوب السودان',
            'ES' => 'إسبانيا',
            'LK' => 'سريلانكا',
            'SD' => 'السودان',
            'SR' => 'سورينام',
            'SE' => 'السويد',
            'CH' => 'سويسرا',
            'SY' => 'سوريا',
            'TJ' => 'طاجيكستان',
            'TZ' => 'تنزانيا',
            'TH' => 'تايلاند',
            'TL' => 'تيمور الشرقية',
            'TG' => 'توغو',
            'TO' => 'تونغا',
            'TT' => 'ترينيداد وتوباغو',
            'TN' => 'تونس',
            'TR' => 'تركيا',
            'TM' => 'تركمانستان',
            'TV' => 'توفالو',
            'UG' => 'أوغندا',
            'UA' => 'أوكرانيا',
            'AE' => 'الإمارات العربية المتحدة',
            'GB' => 'المملكة المتحدة',
            'US' => 'الولايات المتحدة',
            'UY' => 'أوروغواي',
            'UZ' => 'أوزبكستان',
            'VU' => 'فانواتو',
            'VA' => 'الفاتيكان',
            'VE' => 'فنزويلا',
            'VN' => 'فيتنام',
            'YE' => 'اليمن',
            'ZM' => 'زامبيا',
            'ZW' => 'زيمبابوي',
        ];

        return view('auth.register', [
            'countries' => $countries,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country' => ['required', 'string', 'max:2'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // Generate a 6-digit OTP
        $otp = Str::random(6, '0123456789');

        // Create the user but don't log them in yet
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $otp,
        ]);

        // Send OTP to the user's email
    Mail::raw("Your OTP for registration is: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Your OTP for Registration');
        });

        // Store user ID in session to use in OTP verification
        $request->session()->put('pending_user_id', $user->id);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify');
    }

    /**
     * Display the OTP verification form.
     */
    public function showOtpForm(Request $request): View|RedirectResponse
    {
        // Check if there’s a pending user in the session
        if (!$request->session()->has('pending_user_id')) {
            return redirect()->route('register');
        }

        return view('auth.otp-verify');
    }

    /**
     * Handle OTP verification.
     */
/**
 * Handle OTP verification.
 */
public function verifyOtp(Request $request): RedirectResponse
{
    $request->validate([
        'otp' => ['required', 'string', 'size:6'],
    ]);

    // Get the pending user ID from the session
    $userId = $request->session()->get('pending_user_id');
    $user = User::find($userId);

    if (!$user) {
        return back()->withErrors(['otp' => 'Invalid session. Please register again.']);
    }

    // Verify the OTP
    if ($user->otp !== $request->otp) {
        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    // Clear the OTP, update status to active (1), and session
    $user->otp = null;
    $user->status = 1; // تغيير الحالة إلى active
    $user->save();
    
    $request->session()->forget('pending_user_id');

    // Trigger the Registered event and log the user in
    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('home');
}

}
