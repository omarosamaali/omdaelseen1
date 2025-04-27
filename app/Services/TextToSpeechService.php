<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TextToSpeechService {
    public function convertChineseTextToSpeech($text)
    {
        try {
            $fileName = 'chinese_audio_' . Str::random(10) . '.mp3';
            $filePath = 'audio/' . $fileName;

            Storage::disk('public')->makeDirectory('audio');

            $url = 'https://translate.google.com/translate_tts?ie=UTF-8&q=' . urlencode($text) . '&tl=zh-CN&client=tw-ob';
            $audioContent = file_get_contents($url);
            Log::info('URL الطلب: ' . $url); // Use Log:: instead of \Log::
            Log::info('حجم المحتوى الصوتي: ' . strlen($audioContent) . ' بايت');

            if (Storage::disk('public')->put($filePath, $audioContent)) {
                if (Storage::disk('public')->exists($filePath)) {
                    Log::info('تم تخزين الملف بنجاح في: storage/app/public/' . $filePath);
                    return '/storage/audio/' . $fileName;
                } else {
                    Log::error('الملف غير موجود بعد التخزين على قرص public: ' . $filePath);
                }
            } else {
                Log::error('فشل تخزين الملف على قرص public: ' . $filePath);
            }
            return null;
        } catch (\Exception $e) {
            Log::error('خطأ عند تحويل النص إلى صوت: ' . $e->getMessage());
            return null;
        }
    }
}