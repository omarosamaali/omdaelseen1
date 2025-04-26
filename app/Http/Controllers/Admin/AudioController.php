<?php

namespace App\Http\Controllers;

use App\Services\TextToSpeechService;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    protected $textToSpeechService;

    public function __construct(TextToSpeechService $textToSpeechService)
    {
        $this->textToSpeechService = $textToSpeechService;
    }

    /**
     * توليد ملف صوتي من النص
     */
    {
    "success": true,
    "audio_path": "/storage/audio/chinese_audio_abc123.mp3",
    "full_path": "F:\\Omda\\public\\storage\\audio\\chinese_audio_abc123.mp3",
    "file_exists": true,
    "storage_exists": true,
    "storage_linked": true,
    "folder_permissions": "0755"
}
public function generateAudio(Request $request)
{
    $request->validate([
        'text' => 'required|string'
    ]);

    $audioPath = $this->textToSpeechService->convertChineseTextToSpeech($request->text);

    // إضافة معلومات تشخيصية
    $debug = [
        'success' => !empty($audioPath),
        'audio_path' => $audioPath,
        'full_path' => $audioPath ? public_path(ltrim($audioPath, '/')) : null,
        'file_exists' => $audioPath ? file_exists(public_path(ltrim($audioPath, '/'))) : false,
        'storage_exists' => $audioPath ? Storage::exists('public/audio/' . basename($audioPath)) : false
    ];

    return response()->json($debug);
}
}