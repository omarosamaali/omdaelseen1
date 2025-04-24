<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $layout = Auth::check() && Auth::user()->role === 'admin' ? 'layouts.appProfileAdmin' : 'layouts.appProfile';
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

        return view('profile.edit', [
            'user' => $request->user(),
            'layout' => $layout,
            'countries' => $countries
        ]);
    }

    /**
     * Update the user's profile information.
     */
public function update(Request $request)
{
    $request->validate([
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB

        'phone' => ['nullable', 'string', 'max:20'],
        'country' => ['required', 'string', 'max:2'],
    ]);

    $user = $request->user();
    if ($request->hasFile('avatar')) {
    $avatarPath = $request->file('avatar')->store('avatars', 'public');
    $user->avatar = $avatarPath;
}

    $user->update([
        'phone' => $request->phone,
        'country' => $request->country,
    ]);

    return back()->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
