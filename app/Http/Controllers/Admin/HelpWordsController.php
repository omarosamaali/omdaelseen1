<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpWord;
use App\Services\TextToSpeechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HelpWordsController extends Controller
{
    protected $layout;
    protected $ttsService;

    public function __construct(TextToSpeechService $ttsService)
    {
        $this->ttsService = $ttsService;
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    public function index()
    {
        $helpWords = HelpWord::orderBy('order')->get();
        return view('admin.omdaHome.help_words.index', compact('helpWords'))->with('layout', $this->layout);
    }

    public function create()
    {
        return view('admin.omdaHome.help_words.create')->with('layout', $this->layout);
    }

public function store(Request $request, TextToSpeechService $tts)
{
    $validated = $request->validate([
        'word_type' => 'required|string',
        'word_ar' => 'required|string',
        'word_en' => 'nullable|string',
        'word_zh' => 'nullable|string',
        'status' => 'required|string',
        'order' => 'required|integer',
    ]);

    // توليد ملف صوتي للكلمة الصينية (لو موجودة)
    $audioPath = null;
    if (!empty($validated['word_zh'])) {
            $filename = 'word_' . time() . '.ogg';
            $audioContent = $tts->convertToSpeech($validated['word_zh']);

        if ($audioContent) {
            $audioPath = $tts->saveAudioFile($audioContent, $filename);
        }
    }

    // حفظ البيانات في قاعدة البيانات
    $helpWord = new HelpWord();
    $helpWord->fill($validated);
    $helpWord->audio_zh = $audioPath; // المسار الصوتي
    $helpWord->save();

    return redirect()->route('admin.help_words.index')
                     ->with('success', 'تمت إضافة الكلمة بنجاح ✅');
}


    public function update(Request $request, string $id)
    {
        $request->validate([
            'word_ar' => 'required|max:255',
            'word_en' => 'nullable|max:255',
            'word_zh' => 'nullable|max:255',
            'status' => 'required|in:نشط,غير نشط',
            'order' => 'required|integer|min:0',
            'word_type' => 'required|string|in:تحية وتعريف,أسئلة,طلب أو تقديم مساعدة,السفر,التسوق',
        ]);

        $helpWord = HelpWord::findOrFail($id);

        $data = $request->only([
            'word_ar',
            'word_en',
            'word_zh',
            'status',
            'order',
            'word_type'
        ]);

        // إذا تم تغيير النص الصيني، قم بإنشاء ملف صوتي جديد
        if (!empty($request->word_zh) && $request->word_zh !== $helpWord->word_zh) {
            // حذف الملف القديم إن وجد
            if ($helpWord->audio_zh) {
                \Storage::disk('public')->delete($helpWord->audio_zh);
            }

            $audioContent = $this->ttsService->convertToSpeech($request->word_zh);

            if ($audioContent) {
                $filename = Str::slug($request->word_zh) . '_' . time() . '.ogg';
                $audioPath = $this->ttsService->saveAudioFile($audioContent, $filename);
                $data['audio_zh'] = $audioPath;
            }
        }

        $helpWord->update($data);

        return redirect()->route('admin.help_words.index')->with('success', 'تم تحديث الكلمة بنجاح');
    }

    public function show(string $id)
    {
        $helpWord = HelpWord::findOrFail($id);
        return view('admin.omdaHome.help_words.show', compact('helpWord'))->with('layout', $this->layout);
    }

    public function edit(string $id)
    {
        $helpWord = HelpWord::findOrFail($id);
        return view('admin.omdaHome.help_words.edit', compact('helpWord'))->with('layout', $this->layout);
    }

    public function destroy(string $id)
    {
        $helpWord = HelpWord::findOrFail($id);

        // حذف الملف الصوتي إن وجد
        if ($helpWord->audio_zh) {
            \Storage::disk('public')->delete($helpWord->audio_zh);
        }

        $helpWord->delete();
        return redirect()->route('admin.help_words.index')->with('success', 'تم حذف الكلمة بنجاح');
    }
}
