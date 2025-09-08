<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $text = $request->input('text');
        $sourceLang = $request->input('source_lang');
        $targetLangs = $request->input('target_langs');

        $tr = new GoogleTranslate();
        $tr->setSource($sourceLang);

        $translations = [];
        foreach ($targetLangs as $lang) {
            $tr->setTarget($lang);
            try {
                $translations[$lang] = $tr->translate($text);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Translation failed: ' . $e->getMessage()], 500);
            }
        }

        return response()->json($translations);
    }
}