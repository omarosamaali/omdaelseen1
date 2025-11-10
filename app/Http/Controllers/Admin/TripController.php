<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TripFeatures;
use App\Models\TripGuideline;
use App\Models\TripActivity;
use Nette\Utils\Random;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $trips = Trip::all();
        return view('admin.omdaHome.trip.index', compact('trips'));
    }

    public function destroyTrip(Trip $trip){
        $trip->delete();
        return redirect()->route('admin.omdaHome.trip.index')
            ->with('success', 'تم حذف الرحلة بنجاح.');
    }

    public function showTrip(Trip $trip)
    {
        // نجيب المشتركين المرتبطين بالرحلة
        $participants = \App\Models\TripRegistration::with('user')
            ->where('trip_id', $trip->id)
            ->get();

        return view('admin.omdaHome.trip.showTrip', compact('trip', 'participants'));
    }

    public function editTrip(Trip $trip)
    {
        $availableFeatures = TripFeatures::where('status', 'active')->get();
        $availableGuidelines = TripGuideline::where('status', 'active')->get();
        return view('admin.omdaHome.trip.editTrip', compact('trip', 'availableFeatures', 'availableGuidelines'));
    }

    public function editActivity(Trip $trip, TripActivity $activity)
    {
        if ($activity->trip_id !== $trip->id) {
            abort(403, 'Unauthorized action.');
        }
        $places = Places::all(); // Load all places for the dropdown

        return view('admin.omdaHome.trip.edit_activity', compact('places','trip', 'activity'));
    }


    public function create()
    {
        $availableFeatures = TripFeatures::where('status', 'active')->get();
        $availableGuidelines = TripGuideline::where('status', 'active')->get();

        return view('admin.omdaHome.trip.create', compact('availableFeatures', 'availableGuidelines'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'title_ch' => 'required|string|max:255',
                'departure_date' => 'required|date',
                'return_date' => 'required|date',
                'hotel_ar' => 'required|string|max:255',
                'hotel_en' => 'required|string|max:255',
                'hotel_ch' => 'required|string|max:255',
                'transportation_type' => 'required|string',
                'trip_type' => 'required|string',
                'room_type' => 'required|string',
                'shared_room_price' => 'nullable|numeric',
                'private_room_price' => 'nullable|numeric',
                'translators' => 'required|string',
                'meals' => 'nullable|array',
                'airport_pickup' => 'required|boolean',
                'supervisor' => 'required|boolean',
                'factory_visit' => 'required|boolean',
                'tourist_sites_visit' => 'required|boolean',
                'markets_visit' => 'required|boolean',
                'tickets_included' => 'required|boolean',
                'price' => 'nullable|numeric',
                'status' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:90048',
                'trip_features' => 'required|array',
                'trip_features.*' => 'exists:trip_features,id',
                'trip_guidelines' => 'required|array',
                'trip_guidelines.*' => 'exists:trip_guidelines,id',
                'is_paid' => 'required',
                
            ]);

            $validated['trip_features'] = json_encode($validated['trip_features']);
            $validated['trip_guidelines'] = json_encode($validated['trip_guidelines']);
            $validated['reference_number'] = 'REF' . mt_rand(10000000, 99999999);
            $validated['user_id'] = auth()->user()->id;
            $trip = Trip::create($validated);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/trips'), $imageName);
                $trip->image = $imageName;
                $trip->save();
            }

            return redirect()->route('admin.omdaHome.trip.index')
                ->with('success', 'تم إضافة الرحلة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة الرحلة: ' . $e->getMessage());
        }
    }

    public function show(Trip $trip)
    {
        $trip->load(['features', 'guidelines']);
        return view('admin.omdaHome.trip.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $availableFeatures = TripFeatures::all();
        $availableGuidelines = TripGuideline::all();
        $trip->load(['features', 'guidelines']);
        $selectedFeatures = $trip->features->pluck('id')->toArray();
        $selectedGuidelines = $trip->guidelines->pluck('id')->toArray();

        return view('admin.omdaHome.trip.edit', compact('trip', 'availableFeatures', 'availableGuidelines', 'selectedFeatures', 'selectedGuidelines'));
    }
    public function update(Request $request, Trip $trip)
    {
        try {
            $validated = $request->validate([
                'title_ar'            => 'required|string|max:255',
                'title_en'            => 'required|string|max:255',
                'title_ch'            => 'required|string|max:255',
                'departure_date'      => 'required|date',
                'return_date'         => 'required|date',
                'hotel_ar'            => 'required|string|max:255',
                'hotel_en'            => 'required|string|max:255',
                'hotel_ch'            => 'required|string|max:255',
                'transportation_type' => 'required|string',
                'trip_type'           => 'required|string',
                'room_type'           => 'required|string',
                'shared_room_price'   => 'nullable|numeric',
                'private_room_price'  => 'nullable|numeric',
                'translators'         => 'required|string',
                'meals'               => 'nullable|array',
                'airport_pickup'      => 'required|boolean',
                'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'supervisor'          => 'required|boolean',
                'factory_visit'       => 'required|boolean',
                'tourist_sites_visit' => 'required|boolean',
                'markets_visit'       => 'required|boolean',
                'tickets_included'    => 'required|boolean',
                'price'               => 'nullable|numeric',
                'status'              => 'required|string',
                'trip_features'       => 'required|array',
                'trip_features.*'     => 'exists:trip_features,id',
                'trip_guidelines'     => 'required|array',
                'trip_guidelines.*'   => 'exists:trip_guidelines,id',
                'is_paid'             => 'required',
            ]);
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة لو موجودة
                if ($trip->image && file_exists(public_path('images/trips/' . $trip->image))) {
                    unlink(public_path('images/trips/' . $trip->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/trips'), $imageName);
                $validated['image'] = $imageName;
            } else {
                // لو مفيش صورة جديدة، احذف العمود من البيانات المرسلة
                unset($validated['image']);
            }

            // تحديث بيانات الرحلة
            $trip->update($validated);


            return redirect()->route('admin.omdaHome.trip.index')
                ->with('success', 'تم تحديث الرحلة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث الرحلة: ' . $e->getMessage());
        }
    }
    public function createActivity(Trip $trip)
    {
        $places = Places::all(); // Load all places for the dropdown
        return view('admin.omdaHome.trip.create_table', compact('trip', 'places'));
    }
    public function storeActivity(Request $request, Trip $trip)
    {
        $validatedData = $request->validate([
            'date' => 'required|date|after_or_equal:' . $trip->departure_date . '|before_or_equal:' . $trip->return_date,
            'period' => 'required|in:morning,afternoon,evening',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Make required and add webp
            'is_place_related' => 'required|boolean',
            'place_id' => 'required_if:is_place_related,1|nullable|exists:places,id',
            'place_name_ar' => 'required_if:is_place_related,0|nullable|string|max:255',
            'place_name_en' => 'required_if:is_place_related,0|nullable|string|max:255',
            'place_name_zh' => 'required_if:is_place_related,0|nullable|string|max:255',
            'details_ar' => 'required_if:is_place_related,0|nullable|string',
            'details_en' => 'nullable|string',
            'details_zh' => 'nullable|string',
        ], [
            // Custom error messages in Arabic
            'image.nullable' => 'صورة المكان مطلوبة.',
            'image.image' => 'يجب أن يكون الملف صورة صالحة.',
            'image.mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, webp.',
            'image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت.',
            'place_name_ar.required_if' => 'اسم المكان باللغة العربية مطلوب.',
            'place_name_en.required_if' => 'اسم المكان باللغة الإنجليزية مطلوب.',
            'details_ar.required_if' => 'التفاصيل باللغة العربية مطلوبة.',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Validate that the uploaded file is actually an image
            if (!$image->isValid()) {
                return back()->withErrors(['image' => 'فشل في رفع الصورة. حاول مرة أخرى.'])
                    ->withInput();
            }

            // Store the image
            $path = $image->store('activities', 'public');
            $validatedData['image'] = $path;
        }

        $validatedData['trip_id'] = $trip->id;
        $trip->activities()->create($validatedData);

        if ($request->input('add_more')) {
            return redirect()->route('admin.omdaHome.trip.create_table', $trip->id)
                ->with('success', 'تم إضافة الفعالية بنجاح. يمكنك إضافة المزيد.');
        }

        return redirect()->route('admin.omdaHome.trip.trip-table', $trip->id)
            ->with('success', 'تم إضافة الفعالية بنجاح.');
    }


    public function updateActivity(Request $request, Trip $trip, TripActivity $activity)
    {
        if ($activity->trip_id !== $trip->id) {
            abort(403); // Unauthorized action
        }

        $validatedData = $request->validate([
            'date' => 'required|date|after_or_equal:' . $trip->departure_date . '|before_or_equal:' . $trip->return_date,
            'period' => 'required|in:morning,afternoon,evening',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name_ch' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_place_related' => 'required|boolean',
            'place_id' => 'required_if:is_place_related,1|nullable|exists:places,id',
            'place_name_ar' => 'required_if:is_place_related,0|nullable|string|max:255',
            'place_name_en' => 'required_if:is_place_related,0|nullable|string|max:255',
            'place_name_zh' => 'required_if:is_place_related,0|nullable|string|max:255',
            'details_ar' => 'required_if:is_place_related,0|nullable|string',
            'details_en' => 'nullable|string',
            'details_zh' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/activities'), $imageName);
            $validatedData['image'] = $imageName;
        }

        $activity->update($validatedData);

        return redirect()->route('admin.omdaHome.trip.trip-table', $trip->id)
            ->with('success', 'تم تحديث الفعالية بنجاح.');
    }


    // Use route model binding for both Trip and TripActivity
    public function destroyActivity(Trip $trip, TripActivity $activity)
    {
        // The $trip and $activity models are now automatically provided by Laravel.
        // We can add a check to make sure the activity belongs to the trip for security
        if ($activity->trip_id !== $trip->id) {
            abort(403); // Unauthorized action
        }

        $activity->delete();

        return redirect()->route('admin.omdaHome.trip.trip-table', $trip->id)
            ->with('success', 'تم حذف الفعالية بنجاح.');
    }

    public function adds(Request $request)
    {
        return view('admin.omdaHome.trip.adds');
    }

    public function tripTable($id)
    {
        $trip = Trip::with('activities')->findOrFail($id);

        return view('admin.omdaHome.trip.trip-table', compact('trip'));
    }

    public function tripInfo(Request $request)
    {
        return view('admin.omdaHome.trip.trip-info');
    }

    public function createInfo(Request $request)
    {
        return view('admin.omdaHome.trip.create-info');
    }
}
