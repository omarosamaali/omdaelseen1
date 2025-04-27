<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Places;
use App\Models\Explorers;
use App\Models\Branches;
use App\Models\Regions;
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
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }
        // Filter by user_id if provided
  
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

        $places = $query->with(['mainCategory', 'subCategory', 'region'])->paginate(10);
        $currentFilter = $request->filter;

        return view('users.places.index', compact('places', 'currentFilter'))
            ->with('layout', $this->layout);
    }

    public function create()
    {
        $explorers = Explorers::all(['id', 'name_ar']);
        $branches = Branches::all(['id', 'name_ar', 'main']);
        $regions = Regions::all(['id', 'name_ar']);
        
        return view('users.places.create', compact('explorers', 'branches', 'regions'))
            ->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'main_category_id' => 'required|exists:explorers,id',
            'sub_category_id' => 'required|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|url',
            'map_type' => 'required|in:baidu,google,apple',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'details' => 'nullable|string',
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

        return redirect()->route('users.places.index')->with('success', 'تم إضافة المكان بنجاح');
    }

    public function update(Request $request, $id)
    {
        $place = Places::findOrFail($id);

        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'main_category_id' => 'required|exists:explorers,id',
            'sub_category_id' => 'required|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|url',
            'map_type' => 'required|in:baidu,google,apple',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:نشط,غير نشط,محظور',
        ]);

        if ($request->hasFile('avatar')) {
            if ($place->avatar) {
                Storage::disk('public')->delete($place->avatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('places', 'public');
        }

        $additionalImages = $place->additional_images ? json_decode($place->additional_images, true) : [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('place_images', 'public');
            }
            $validatedData['additional_images'] = json_encode($additionalImages);
        }

        $validatedData['status'] = $this->normalizeStatus($validatedData['status']);

        $place->update($validatedData);

        return redirect()->route('users.places.index')->with('success', 'تم تحديث المكان بنجاح');
    }

    public function edit($id)
    {
        $place = Places::findOrFail($id);
        $explorers = Explorers::all(['id', 'name_ar']);
        $branches = Branches::all(['id', 'name_ar', 'main']);
        $regions = Regions::all(['id', 'name_ar']);
        
        return view('users.places.edit', compact('place', 'explorers', 'branches', 'regions'))
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
                $additionalImages = array_values($additionalImages); // إعادة ترتيب المصفوفة
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
        return view('users.places.show', compact('place'))
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
        return redirect()->route('users.places.index')->with('success', 'تم حذف المكان بنجاح');
    }
}