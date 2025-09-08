<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $locale = $request->input('locale');

        // تأكد من صحة الـ locale
        if (in_array($locale, ['en', 'ar', 'zh'])) {
            // حط الـ locale في الـ session
            Session::put('locale', $locale);

            // طبقه فوراً على الـ request ده
            App::setLocale($locale);

            return response()->json([
                'success' => true,
                'locale' => $locale,
                'message' => 'Language changed successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid locale'
        ], 400);
    }
}
