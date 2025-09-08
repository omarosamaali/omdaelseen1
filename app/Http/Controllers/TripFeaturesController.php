<?php

namespace App\Http\Controllers;

use App\Models\TripFeatures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripFeaturesController extends Controller
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
        $guidelines = TripFeatures::orderBy('order')->get();
        return view('admin.omdaHome.trip-features.index', compact('guidelines'))->with('layout', $this->layout);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.omdaHome.trip-features.create')->with('layout', $this->layout);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ch' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
        ]);

        TripFeatures::create($validated);

        return redirect()->route('admin.omdaHome.trip-features.index')
            ->with('success', 'تم إضافة الإرشاد بنجاح.');
    }

    public function show(TripFeatures $tripFeature)
    {
        return view('admin.omdaHome.trip-features.show', compact('tripFeature'))->with('layout', $this->layout);
    }

    public function edit(TripFeatures $tripFeature)
    {
        return view('admin.omdaHome.trip-features.edit', compact('tripFeature'))->with('layout', $this->layout);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TripFeatures $tripGuideline)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ch' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
        ]);

        $tripGuideline->update($validated);

        return redirect()->route('admin.omdaHome.trip-features.index')
            ->with('success', 'تم تحديث الإرشاد بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TripFeatures $tripFeature)
    {
        $tripFeature->delete();

        return redirect()->route('admin.omdaHome.trip-features.index')
            ->with('success', 'تم حذف الإرشاد بنجاح.');
    }
}
