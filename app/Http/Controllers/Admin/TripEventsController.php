<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\TripEvent;
use App\Models\Places;
use App\Models\TripActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripEventsController extends Controller
{
    /**
     * عرض فورم إضافة حدث جديد للرحلة
     */
    public function create($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $places = Places::where('status', 'active')->get();
        $dateRange = $trip->getDateRange();

        return view('admin.trip-events.create', compact('trip', 'places', 'dateRange'));
    }

    /**
     * حفظ حدث جديد
     */
    public function storeActivity(Request $request, Trip $trip)
    {
        // Log the incoming request data for debugging
        \Log::info('Request Data:', $request->all());

        $rules = [
            'date' => 'required|date|after_or_equal:' . $trip->departure_date . '|before_or_equal:' . $trip->return_date,
            'period' => 'required|in:morning,afternoon,evening',
            'status' => 'required|in:active,inactive',
            'is_place_related' => 'required|boolean',
            'place_id' => 'required_if:is_place_related,1|nullable|exists:places,id',
            'place_name_ar' => 'required_if:is_place_related,0|nullable|string|max:255',
            'place_name_en' => 'required_if:is_place_related,0|nullable|string|max:255',
            'place_name_zh' => 'nullable|string|max:255',
            'details_ar' => 'required_if:is_place_related,0|nullable|string',
            'details_en' => 'nullable|string',
            'details_zh' => 'nullable|string',
        ];

        // Add image validation rule
        $rules['image'] = 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048';

        // Validate the request
        $validatedData = $request->validate($rules);

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                if (!$image->isValid()) {
                    \Log::error('Invalid file upload', ['error' => $image->getError()]);
                    return back()->withErrors(['image' => 'فشل في رفع الصورة.'])->withInput();
                }
                // Simulate image upload without saving
                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'activities/' . $fileName; // Simulated path
                $validatedData['image'] = $path;
                \Log::info('Image upload simulated (not saved to storage)', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('Image upload simulation failed', ['error' => $e->getMessage()]);
                return back()->withErrors(['image' => 'فشل في رفع الصورة: ' . $e->getMessage()])->withInput();
            }
        }

        // Add trip_id to validated data
        $validatedData['trip_id'] = $trip->id;

        try {
            // Simulate successful activity creation without saving to the database
            \Log::info('Activity creation simulated (not saved to database)', ['data' => $validatedData]);

            if ($request->input('add_more')) {
                return redirect()->route('admin.omdaHome.trip.create_table', $trip->id)
                    ->with('success', 'تم إضافة الفعالية بنجاح (غير محفوظة في قاعدة البيانات). يمكنك إضافة المزيد.');
            }

            return redirect()->route('admin.omdaHome.trip.trip-table', $trip->id)
                ->with('success', 'تم إضافة الفعالية بنجاح (غير محفوظة في قاعدة البيانات).');
        } catch (\Exception $e) {
            \Log::error('Activity creation simulation failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'فشل في معالجة الفعالية: ' . $e->getMessage()])->withInput();
        }
    }
    /**
     * عرض جميع أحداث الرحلة
     */
    public function index($tripId)
    {
        $trip = Trip::with('events.place')->findOrFail($tripId);
        $events = $trip->getEventsOrderedByDate();

        return view('admin.trip-events.index', compact('trip', 'events'));
    }

    /**
     * تحديث حدث
     */
    public function update(Request $request, $tripId, $eventId)
    {
        $trip = Trip::findOrFail($tripId);
        $event = TripEvent::where('trip_id', $tripId)->findOrFail($eventId);

        $validator = Validator::make($request->all(), [
            'event_date' => 'required|date|after_or_equal:' . $trip->departure_date . '|before_or_equal:' . $trip->return_date,
            'time_period' => 'required|in:morning,afternoon,evening',
            'event_type' => 'required|in:existing_place,new_event',
            'place_id' => 'required_if:event_type,existing_place|exists:places,id',
            'event_name_ar' => 'required_if:event_type,new_event|string|max:255',
            'event_name_en' => 'nullable|string|max:255',
            'event_name_ch' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $eventData = [
            'event_date' => $request->event_date,
            'time_period' => $request->time_period,
            'event_type' => $request->event_type,
            'status' => $request->status,
            'place_id' => null,
            'event_name_ar' => null,
            'event_name_en' => null,
            'event_name_ch' => null
        ];

        if ($request->event_type === 'existing_place') {
            $eventData['place_id'] = $request->place_id;
        } else {
            $eventData['event_name_ar'] = $request->event_name_ar;
            $eventData['event_name_en'] = $request->event_name_en;
            $eventData['event_name_ch'] = $request->event_name_ch;
        }

        $event->update($eventData);

        return redirect()->route('admin.trip.events.index', $tripId)
            ->with('success', 'تم تحديث الحدث بنجاح!');
    }

    /**
     * حذف حدث
     */
    public function destroy($tripId, $eventId)
    {
        $event = TripEvent::where('trip_id', $tripId)->findOrFail($eventId);
        $event->delete();

        return redirect()->route('admin.trip.events.index', $tripId)
            ->with('success', 'تم حذف الحدث بنجاح!');
    }

    /**
     * API للحصول على التواريخ المتاحة للرحلة
     */
    public function getAvailableDates($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $dates = $trip->getDateRange();

        return response()->json([
            'dates' => $dates->map(function ($date) {
                return [
                    'value' => $date->format('Y-m-d'),
                    'label' => $date->format('d-m-Y')
                ];
            })
        ]);
    }
}
