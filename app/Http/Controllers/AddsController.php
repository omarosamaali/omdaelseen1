<?php

namespace App\Http\Controllers;

use App\Models\Adds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    public function index()
    {
        $adds = Adds::orderBy('created_at', 'desc')->get();
        return view('admin.omdaHome.adds.index', compact('adds'))->with('layout', $this->layout);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.omdaHome.adds.create')->with('layout', $this->layout);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_ar' => 'required|string|max:255',
            'type_en' => 'required|string|max:255',
            'type_zh' => 'required|string|max:255',
            'details_ar' => 'required|string',
            'details_en' => 'required|string',
            'details_zh' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('adds', 'public');
            $validated['image'] = $imagePath;
        }
        Adds::create($validated);

        return redirect()->route('admin.omdaHome.adds.index')
            ->with('success', 'تم إضافة الإضافة  بنجاح.');
    }

    public function show($id)
    {
        $adds = Adds::findOrFail($id);
        return view('admin.omdaHome.adds.show', compact('adds'))->with('layout', $this->layout);
    }

    public function edit($id) // تم تغيير البارامتر من Adds $adds إلى $id
    {
        $add = Adds::findOrFail($id);
        return view('admin.omdaHome.adds.edit', compact('add'))->with('layout', $this->layout);
    }

    public function update(Request $request, $id) // تم تغيير البارامتر من Adds $add إلى $id
    {
        $add = Adds::findOrFail($id);

        $validated = $request->validate([
            'type_ar' => 'required|string|max:255',
            'type_en' => 'nullable|string|max:255',
            'type_zh' => 'nullable|string|max:255',
            'details_ar' => 'nullable|string',
            'details_en' => 'nullable|string',
            'details_zh' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($add->image && \Storage::exists('public/' . $add->image)) {
                \Storage::delete('public/' . $add->image);
            }

            $imagePath = $request->file('image')->store('adds', 'public');
            $validated['image'] = $imagePath;
        }

        $add->update($validated);

        return redirect()->route('admin.omdaHome.adds.index')
            ->with('success', 'تم تحديث الإضافة  بنجاح.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $add = Adds::findOrFail($id);
        if ($add->image && \Storage::exists('public/' . $add->image)) {
            \Storage::delete('public/' . $add->image);
        }
        $add->delete();

        return redirect()->route('admin.omdaHome.adds.index')
            ->with('success', 'تم حذف الإضافة  بنجاح.');
    }
}
