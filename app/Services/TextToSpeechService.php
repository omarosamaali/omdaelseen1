<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class TextToSpeechService
{
    protected $voice;
    protected $languageCode;

    public function __construct()
    {
        // إعداد الصوت واللغة الصينية
        $this->voice = 'cmn-CN-Standard-A';
        $this->languageCode = 'zh-CN';
    }

    /**
     * تحويل النص إلى صوت (محاكاة - يمكن لاحقًا ربطه بـ API حقيقي)
     */
    public function convertToSpeech($text, $languageCode = 'zh-CN')
    {
        try {
            $url = 'https://translate.google.com/translate_tts';

            $response = \Http::timeout(30)->withHeaders([
                'User-Agent' => 'Mozilla/5.0', // ضروري علشان Google يرد
            ])->get($url, [
                'ie' => 'UTF-8',
                'q' => $text,
                'tl' => $languageCode,
                'client' => 'tw-ob',
            ]);

            if ($response->successful()) {
                return $response->body(); // صوت فعلي بصيغة mp3
            }

            \Log::error('TTS API Error: ' . $response->status());
            return null;
        } catch (\Exception $e) {
            \Log::error('TTS Exception: ' . $e->getMessage());
            return null;
        }
    }


    /**
     * حفظ ملف الصوت في مجلد storage/public/audio/help_words/
     */
    public function saveAudioFile(string $audioContent, string $filename)
    {
        $directory = 'audio/help_words';
        \Storage::disk('public')->makeDirectory($directory);

        $path = $directory . '/' . $filename;
        \Storage::disk('public')->put($path, $audioContent);

        return $path;
    }
}
