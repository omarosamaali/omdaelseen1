<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use App\Models\Report;
use App\Models\Places;
use App\Models\Favorites;
use App\Models\Rating;
use App\Models\ReviewReport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
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

        View::share('countries', $countries);

        View::composer(['mobile.profile.profileAdmin', 'mobile.welcome'], function ($view) {
            $totalCount = Report::count() + Favorites::count() + Rating::count() + ReviewReport::count();
            $hiddenNotificationsCount = 0;
            $hiddenNotificationsJson = Cookie::get('hidden_notifications');
            if ($hiddenNotificationsJson) {
                $hiddenNotifications = json_decode($hiddenNotificationsJson, true);
                if (is_array($hiddenNotifications)) {
                    $hiddenNotificationsCount = count($hiddenNotifications);
                }
            }

            $finalCount = max(0, $totalCount - $hiddenNotificationsCount);
            $view->with('countNotifications', $finalCount);
        });
        
        View::composer(['mobile.profile.profile', 'mobile.welcome'], function ($view) {
            $userId = Auth::user()?->id;
            $userReportsCount = Report::where('user_id', $userId)->count();
            $reportsAgainstUserPlacesCount = Report::whereIn('place_id', function ($query) use ($userId) {
                $query->select('id')
                    ->from('places')
                    ->where('user_id', $userId);
            })->count();
            $favoritesCount = Favorites::where('user_id', $userId)->count();
            $ratingsCount = Rating::where('user_id', $userId)->count();
            $reviewReportsCount = ReviewReport::where('user_id', $userId)->count();
            $totalCount = +
                $userReportsCount +
                $reportsAgainstUserPlacesCount +
                $favoritesCount +
                $ratingsCount +
                $reviewReportsCount;

            $hiddenNotificationsCount = 0;
            $hiddenNotificationsJson = Cookie::get('hidden_notifications');
            if ($hiddenNotificationsJson) {
                $hiddenNotifications = json_decode($hiddenNotificationsJson, true);
                if (is_array($hiddenNotifications)) {
                    $hiddenNotificationsCount = count($hiddenNotifications);
                }
            }

            $finalCount = max(0, $totalCount - $hiddenNotificationsCount);

            // تمرير البيانات للـ view
            $view->with([
                'countNotificationsUser' => $finalCount,
                'reportsAgainstUserPlaces' => $reportsAgainstUserPlacesCount // يمكنك استخدام هذا في الـ view
            ]);
        });
        
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('user', Auth::user());
            }
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('user', Auth::user());
            }
        });
    }
}
