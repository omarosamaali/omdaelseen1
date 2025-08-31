<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Places;
use App\Models\Explorers;
use App\Models\Branches;
use App\Models\Regions;
use App\Models\Favorites;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlacesController extends Controller
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
        $query = Places::query();

        // Filter by user_id if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Handle search
        if ($request->has('user_search') && $request->user_search) {
            $query->where('name_ar', 'like', '%' . $request->user_search . '%')
                ->orWhere('name_en', 'like', '%' . $request->user_search . '%')
                ->orWhere('name_ch', 'like', '%' . $request->user_search . '%');
        }

        // Handle filtering
        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter === 'active') {
                $query->where('status', 'active');
            } elseif ($filter === 'inactive') {
                $query->where('status', 'inactive');
            } elseif ($filter === 'banned') {
                $query->where('status', 'banned');
            }
        }

        // Load places with related data
        $places = $query->with(['mainCategory', 'subCategory', 'region'])->paginate(10);

        // Get favorites count per place
        $favoritesCount = Favorites::select('place_id')
            ->selectRaw('COUNT(user_id) as users_count')
            ->groupBy('place_id')
            ->get()
            ->pluck('users_count', 'place_id')
            ->toArray();

        // Get ratings count and average rating per place
        $ratingsData = Rating::select('place_id')
            ->selectRaw('COUNT(id) as ratings_count')
            ->selectRaw('AVG(rating) as average_rating')
            ->groupBy('place_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->place_id => [
                        'ratings_count' => $item->ratings_count,
                        'average_rating' => number_format($item->average_rating, 1)
                    ]
                ];
            })
            ->toArray();

        $currentFilter = $request->filter;

        return view('admin.omdaHome.places.index', compact('places', 'currentFilter', 'favoritesCount', 'ratingsData'))
            ->with('layout', $this->layout);
    }
    public function create()
    {
        $explorers = Explorers::all(['id', 'name_ar']);
        $branches = Branches::all(['id', 'name_ar', 'main']);
        $regions = Regions::all(['id', 'name_ar']);

        return view('admin.omdaHome.places.create', compact('explorers', 'branches', 'regions'))
            ->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'details_ar' => 'nullable|string',
            'details_en' => 'nullable|string',
            'details_ch' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'main_category_id' => 'required|exists:explorers,id',
            'sub_category_id' => 'required|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|string|max:500',
            'map_type' => 'required|string|in:baidu,google,apple',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:نشط,غير نشط,محظور',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('places', 'public');
        }

        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('place_images', 'public');
            }
            $data['additional_images'] = json_encode($additionalImages);
        }

        $data['status'] = $this->normalizeStatus($data['status']);
        $data['user_id'] = Auth::id();

        Places::create($data);

        return redirect()->route('admin.places.index')->with('success', 'تم إضافة المكان بنجاح');
    }

    public function update(Request $request, $id)
    {
        $place = Places::findOrFail($id);

        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'details_ar' => 'nullable|string',
            'details_en' => 'nullable|string',
            'details_ch' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'main_category_id' => 'required|exists:explorers,id',
            'sub_category_id' => 'required|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|string|max:500',
            'map_type' => 'required|in:baidu,google,apple',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:نشط,غير نشط,محظور',
        ]);

        if ($request->hasFile('avatar')) {
            if ($place->avatar) {
                Storage::disk('public')->delete($place->avatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('places', 'public');
        }

        if ($request->hasFile('additional_images')) {
            if ($place->additional_images) {
                $oldImages = json_decode($place->additional_images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $additionalImages = [];
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('place_images', 'public');
            }
            $validatedData['additional_images'] = json_encode($additionalImages);
        }

        $validatedData['status'] = $this->normalizeStatus($validatedData['status']);

        $place->update($validatedData);

        return redirect()->route('admin.places.index')->with('success', 'تم تحديث المكان بنجاح');
    }

    public function edit($id)
    {
        $place = Places::findOrFail($id);
        $explorers = Explorers::all(['id', 'name_ar']);
        $branches = Branches::all(['id', 'name_ar', 'main']);
        $regions = Regions::all(['id', 'name_ar']);

        return view('admin.omdaHome.places.edit', compact('place', 'explorers', 'branches', 'regions'))
            ->with('layout', $this->layout);
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'image_type' => 'required|in:avatar,additional',
            'image_index' => 'required_if:image_type,additional|integer',
        ]);

        $place = Places::findOrFail($request->place_id);

        if ($request->image_type === 'avatar') {
            if ($place->avatar) {
                Storage::disk('public')->delete($place->avatar);
                $place->avatar = null;
                $place->save();
                return response()->json(['success' => true, 'message' => 'تم حذف الصورة الرئيسية بنجاح']);
            }
            return response()->json(['success' => false, 'message' => 'لا توجد صورة رئيسية للحذف']);
        }

        if ($request->image_type === 'additional') {
            $additionalImages = $place->additional_images ? json_decode($place->additional_images, true) : [];
            if (isset($additionalImages[$request->image_index])) {
                Storage::disk('public')->delete($additionalImages[$request->image_index]);
                unset($additionalImages[$request->image_index]);
                $additionalImages = array_values($additionalImages);
                $place->additional_images = $additionalImages ? json_encode($additionalImages) : null;
                $place->save();
                return response()->json(['success' => true, 'message' => 'تم حذف الصورة الإضافية بنجاح']);
            }
            return response()->json(['success' => false, 'message' => 'الصورة الإضافية غير موجودة']);
        }

        return response()->json(['success' => false, 'message' => 'نوع الصورة غير صالح']);
    }

    private function normalizeStatus($status)
    {
        if (in_array($status, ['نشط', 'active'])) {
            return 'active';
        } elseif (in_array($status, ['غير نشط', 'inactive'])) {
            return 'inactive';
        } else {
            return 'banned';
        }
    }

    public function show($id)
    {
        $place = Places::with(['mainCategory', 'subCategory', 'region', 'user'])->findOrFail($id);
        return view('admin.omdaHome.places.show', compact('place'))
            ->with('layout', $this->layout);
    }

    public function destroy($id)
    {
        $place = Places::findOrFail($id);
        if ($place->avatar) {
            Storage::disk('public')->delete($place->avatar);
        }
        if ($place->additional_images) {
            foreach (json_decode($place->additional_images, true) as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $place->delete();
        return redirect()->route('admin.places.index')->with('success', 'تم حذف المكان بنجاح');
    }
}
