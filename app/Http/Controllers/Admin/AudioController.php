<?php

namespace App\Http\Controllers;

use App\Services\TextToSpeechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Add this import

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
            'storage_exists' => $audioPath ? Storage::exists('public/audio/' . basename($audioPath)) : false,
            'storage_linked' => is_link(public_path('storage')),
            'folder_permissions' => $audioPath ? substr(sprintf('%o', fileperms(public_path('storage/audio'))), -4) : null
        ];

        return response()->json($debug);
    }
}