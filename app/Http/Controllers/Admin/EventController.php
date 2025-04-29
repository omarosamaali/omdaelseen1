<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    public function index(Request $request)
    {
        $events = Event::with('region');

        if ($request->has('interest_id')) {
            $events->where('id', $request->input('interest_id'));
        }

        $events = $events->get();

        return view('admin.omdaHome.events.index', compact('events'))->with('layout', $this->layout);
    }

    public function meetIndex(Request $request)
    {
        $events = Event::with('region')->where('type', 'مناسبة');

        if ($request->has('interest_id')) {
            $events->where('id', $request->input('interest_id'));
        }

        $events = $events->get();

        return view('users.meet.index', compact('events'))->with('layout', $this->layout);
    }

    public function create()
    {
        $regions = \App\Models\Regions::all();
        return view('admin.omdaHome’em”.events.create', compact('regions'))->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|max:255',
            'title_en' => 'nullable|max:255',
            'title_zh' => 'nullable|max:255',
            'description_ar' => 'required|max:1000000',
            'description_en' => 'nullable|max:1000000',
            'description_zh' => 'nullable|max:1000000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:معرض,مناسبة',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'region_id' => 'required|exists:regions,id',
        ]);

        $eventData = $request->only([
            'title_ar',
            'title_en',
            'title_zh',
            'description_ar',
            'description_en',
            'description_zh',
            'start_date',
            'end_date',
            'type',
            'status',
            'region_id'
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('events', 'public');
            $eventData['avatar'] = $path;
        }

        Event::create($eventData);

        return redirect()->route('admin.events.index')->with('success', 'تم إضافة الحدث/المعرض بنجاح');
    }

    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.omdaHome.events.show', compact('event'))->with('layout', $this->layout);
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $regions = \App\Models\Regions::all();
        return view('admin.omdaHome.events.edit', compact('event', 'regions'))->with('layout', $this->layout);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title_ar' => 'required|max:255',
            'title_en' => 'nullable|max:255',
            'title_zh' => 'nullable|max:255',
            'description_ar' => 'required|max:1000000',
            'description_en' => 'nullable|max:1000000',
            'description_zh' => 'nullable|max:1000000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:معرض,مناسبة',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'region_id' => 'required|exists:regions,id',
        ]);

        $event = Event::findOrFail($id);

        $eventData = $request->only([
            'title_ar',
            'title_en',
            'title_zh',
            'description_ar',
            'description_en',
            'description_zh',
            'start_date',
            'end_date',
            'type',
            'status',
            'region_id'
        ]);

        if ($request->hasFile('avatar')) {
            if ($event->avatar) {
                Storage::disk('public')->delete($event->avatar);
            }
            $path = $request->file('avatar')->store('events', 'public');
            $eventData['avatar'] = $path;
        }

        $event->update($eventData);

        return redirect()->route('admin.events.index')->with('success', 'تم تحديث الحدث/المعرض بنجاح');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->avatar) {
            Storage::disk('public')->delete($event->avatar);
        }

        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'تم حذف الحدث/المعرض بنجاح');
    }

    public function deleteImage(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        if ($event->avatar) {
            Storage::disk('public')->delete($event->avatar);
            $event->avatar = null;
            $event->save();
        }

        return response()->json(['success' => true]);
    }
}
