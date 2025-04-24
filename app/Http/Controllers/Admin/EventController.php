<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function index()
    {
        $events = Event::all();
        return view('admin.omdaHome.events.index', compact('events'))->with('layout', $this->layout);
    }

    public function create()
    {
        return view('admin.omdaHome.events.create')->with('layout', $this->layout);
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
            // 'address_ar' => 'required|max:255',
            // 'address_en' => 'nullable|max:255',
            // 'address_zh' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:معرض,مناسبة',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $eventData = $request->only([
            'title_ar', 'title_en', 'title_zh',
            'description_ar', 'description_en', 'description_zh',
            // 'address_ar', 'address_en', 'address_zh',
            'start_date', 'end_date', 'type', 'status'
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
        return view('admin.omdaHome.events.show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.omdaHome.events.edit', compact('event'))->with('layout', $this->layout);
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
            // 'address_ar' => 'required|max:255',
            // 'address_en' => 'nullable|max:255',
            // 'address_zh' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:معرض,مناسبة',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $event = Event::findOrFail($id);

        $eventData = $request->only([
            'title_ar', 'title_en', 'title_zh',
            'description_ar', 'description_en', 'description_zh',
            // 'address_ar', 'address_en', 'address_zh',
            'start_date', 'end_date', 'type', 'status'
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