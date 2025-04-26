<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TextToSpeechService {
    /**
     * تحويل النص الصيني إلى ملف صوتي وحفظه
     * 
     * @param string $text النص الصيني
     * @return string|null مسار الملف الصوتي
     */
     public function convertChineseTextToSpeech($text)
{
    try {
        $fileName = 'chinese_audio_' . Str::random(10) . '.mp3';
        $filePath = 'audio/' . $fileName; // مسار نسبي داخل قرص public

        // تأكد من وجود المجلد على قرص public
        Storage::disk('public')->makeDirectory('audio');

        // تنزيل المحتوى الصوتي
        $url = 'https://translate.google.com/translate_tts?ie=UTF-8&q=' . urlencode($text) . '&tl=zh-CN&client=tw-ob';
        $audioContent = file_get_contents($url);
        \Log::info('URL الطلب: ' . $url);
        \Log::info('حجم المحتوى الصوتي: ' . strlen($audioContent) . ' بايت');

        // تخزين الملف على قرص public
        if (Storage::disk('public')->put($filePath, $audioContent)) {
            // تحقق من وجود الملف بعد التخزين على قرص public
            if (Storage::disk('public')->exists($filePath)) {
                \Log::info('تم تخزين الملف بنجاح في: storage/app/public/' . $filePath);
                return '/storage/audio/' . $fileName;
            } else {
                \Log::error('الملف غير موجود بعد التخزين على قرص public: ' . $filePath);
            }
        } else {
            \Log::error('فشل تخزين الملف على قرص public: ' . $filePath);
        }
        return null;
    } catch (\Exception $e) {
        \Log::error('خطأ عند تحويل النص إلى صوت: ' . $e->getMessage());
        return null;
    }
}
}