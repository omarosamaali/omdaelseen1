<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('admin.omdaHome.faq.index', compact('faqs'))->with('layout', $this->layout);
    }

    public function create()
    {
        return view('admin.omdaHome.faq.create')->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_ar' => 'required|max:1000',
            'question_en' => 'nullable|max:1000',
            'question_zh' => 'nullable|max:1000',
            'answer_ar' => 'required|max:10000',
            'answer_en' => 'nullable|max:10000',
            'answer_zh' => 'nullable|max:10000',
            'status' => 'required|in:نشط,غير نشط',
            'order' => 'required|integer|min:0',
            'category' => 'required|in:الطلب,الشحن,الأماكن,اخرى',
        ]);

        Faq::create($request->only([
            'question_ar',
            'question_en',
            'question_zh',
            'answer_ar',
            'answer_en',
            'answer_zh',
            'status',
            'order',
            'category'
        ]));

        return redirect()->route('admin.faq.index')->with('success', 'تم إضافة السؤال بنجاح');
    }

    public function show(string $id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.omdaHome.faq.show', compact('faq'))->with('layout', $this->layout);
    }

    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.omdaHome.faq.edit', compact('faq'))->with('layout', $this->layout);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'question_ar' => 'required|max:1000',
            'question_en' => 'nullable|max:1000',
            'question_zh' => 'nullable|max:1000',
            'answer_ar' => 'required|max:10000',
            'answer_en' => 'nullable|max:10000',
            'answer_zh' => 'nullable|max:10000',
            'status' => 'required|in:نشط,غير نشط',
            'order' => 'required|integer|min:0',
            'category' => 'required|in:الطلب,الشحن,الأماكن,اخرى',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->only([
            'question_ar',
            'question_en',
            'question_zh',
            'answer_ar',
            'answer_en',
            'answer_zh',
            'status',
            'order',
            'category'
        ]));

        return redirect()->route('admin.faq.index')->with('success', 'تم تحديث السؤال بنجاح');
    }

    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('admin.faq.index')->with('success', 'تم حذف السؤال بنجاح');
    }
}
