<?php

namespace App\Http\Controllers;

use App\Models\TripGuideline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripGuidelineController extends Controller
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
        $guidelines = TripGuideline::orderBy('order')->get();
        return view('admin.omdaHome.trip.trip-info', compact('guidelines'))->with('layout', $this->layout);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.omdaHome.trip.trip-create');
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

        TripGuideline::create($validated);

        return redirect()->route('admin.omdaHome.trip.trip-info')
            ->with('success', 'تم إضافة الإرشاد بنجاح.');
    }

    public function edit(TripGuideline $tripGuideline)
    {
        return view('admin.omdaHome.trip.edit', compact('tripGuideline'))->with('layout', $this->layout);;
    }

    public function show(TripGuideline $tripGuideline)
    {
        return view('admin/omdaHome/trip/show', compact('tripGuideline'))->with('layout', $this->layout);;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TripGuideline $tripGuideline)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'name_ch' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'order' => 'required|integer|min:0',
        ]);

        $tripGuideline->update($validated);

        return redirect()->route('admin.omdaHome.trip.trip-info')
            ->with('success', 'تم تحديث الإرشاد بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TripGuideline $tripGuideline)
    {
        $tripGuideline->delete();

        return redirect()->route('admin.omdaHome.trip.trip-info')
            ->with('success', 'تم حذف الإرشاد بنجاح.');
    }
}
