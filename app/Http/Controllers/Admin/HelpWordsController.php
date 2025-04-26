<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpWord;
use App\Services\TextToSpeechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpWordsController extends Controller
{
    protected $layout;
    protected $textToSpeechService;

    public function __construct(TextToSpeechService $textToSpeechService)
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
        $this->textToSpeechService = $textToSpeechService;
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

    public function store(Request $request)
    {
        $request->validate([
            'word_ar' => 'required|max:255',
            'word_en' => 'nullable|max:255',
            'word_zh' => 'nullable|max:255',
            'status' => 'required|in:نشط,غير نشط',
            'order' => 'required|integer|min:0',
        ]);

        $data = $request->only([
            'word_ar', 'word_en', 'word_zh',
            'status', 'order'
        ]);

        // إذا كان هناك نص صيني، قم بإنشاء ملف صوتي له
        if (!empty($data['word_zh'])) {
            $audioPath = $this->textToSpeechService->convertChineseTextToSpeech($data['word_zh']);
            $data['word_zh_audio'] = $audioPath;
        }

        HelpWord::create($data);

        return redirect()->route('admin.help_words.index')->with('success', 'تم إضافة الكلمة بنجاح');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'word_ar' => 'required|max:255',
            'word_en' => 'nullable|max:255',
            'word_zh' => 'nullable|max:255',
            'status' => 'required|in:نشط,غير نشط',
            'order' => 'required|integer|min:0',
        ]);

        $helpWord = HelpWord::findOrFail($id);
        
        $data = $request->only([
            'word_ar', 'word_en', 'word_zh',
            'status', 'order'
        ]);

        // إذا تم تعديل النص الصيني، قم بإنشاء ملف صوتي جديد
        if (!empty($data['word_zh']) && $data['word_zh'] !== $helpWord->word_zh) {
            $audioPath = $this->textToSpeechService->convertChineseTextToSpeech($data['word_zh']);
            $data['word_zh_audio'] = $audioPath;
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
        $helpWord->delete();
        return redirect()->route('admin.help_words.index')->with('success', 'تم حذف الكلمة بنجاح');
    }
}