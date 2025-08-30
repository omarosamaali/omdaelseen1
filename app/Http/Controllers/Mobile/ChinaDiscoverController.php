<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Explorers;
use App\Models\Places;
use App\Models\Regions;
use App\Models\Branches;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ChinaDiscoverController extends Controller
{
    public function index($id = null)
    {
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $latestPlaces = Places::with('mainCategory')->latest()->take(5)->get();
        $explorers = Explorers::all();
        $places = Places::with('mainCategory')->where('main_category_id', $id ?? '!=', $id)->get();
        return view('mobile.china-discovers.index', compact('banners', 'explorers', 'places', 'latestPlaces'));
    }

    public function allPlaces($region_id = null)
    {
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $regions = Regions::all();
        $placesQuery = Places::query();
        if ($region_id) {
            $placesQuery->where('region_id', $region_id);
        }
        $mainCategoryIds = $placesQuery->distinct()->pluck('main_category_id');
        $explorers = Explorers::whereIn('id', $mainCategoryIds)->get();
        return view('mobile.china-discovers.all-places', compact('regions', 'banners', 'explorers', 'region_id'));
    }

    public function create()
    {
        $explorers = Explorers::all();
        $regions = Regions::all();
        return view('mobile.china-discovers.create', compact('explorers', 'regions'));
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
            'sub_category_id' => 'nullable|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('places/avatars', 'public');
        }

        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('places/additional', 'public');
            }
            $data['additional_images'] = json_encode($additionalImages);
        }

        $data['user_id'] = Auth::id();
        Places::create($data);
        return redirect()->route('mobile.china-discovers.index')->with('success', 'تم إضافة المكان بنجاح!');
    }

    public function edit($id)
    {
        $place = Places::findOrFail($id);
        if ($place->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا المكان.');
        }
        $explorers = Explorers::all();
        $regions = Regions::all();
        return view('mobile.china-discovers.edit', compact('place', 'explorers', 'regions'));
    }

    public function update(Request $request, $id)
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
            'sub_category_id' => 'nullable|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $place = Places::findOrFail($id);
        if ($place->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا المكان.');
        }

        if ($request->hasFile('avatar')) {
            if ($place->avatar && Storage::disk('public')->exists($place->avatar)) {
                Storage::disk('public')->delete($place->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('places/avatars', 'public');
        }

        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            if ($place->additional_images) {
                $oldImages = json_decode($place->additional_images, true);
                foreach ($oldImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('places/additional', 'public');
            }
            $data['additional_images'] = json_encode($additionalImages);
        }

        $data['user_id'] = Auth::id();
        $place->update($data);
        return redirect()->route('mobile.china-discovers.index')->with('success', 'تم تعديل المكان بنجاح!');
    }

    public function getSubcategories($id)
    {
        // جلب التصنيفات الفرعية التي تنتمي إلى التصنيف الرئيسي المحدد
        $subcategories = Branches::where('main', $id)->get();

        return response()->json($subcategories);
    }


    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'source_lang' => 'required|in:ar,en,zh-CN',
            'target_langs' => 'required|array',
            'target_langs.*' => 'in:ar,en,zh-CN',
        ]);

        $tr = new GoogleTranslate();
        $tr->setSource($request->source_lang);

        $translations = [];
        foreach ($request->target_langs as $lang) {
            $tr->setTarget($lang);
            try {
                $translations[$lang] = $tr->translate($request->text);
            } catch (\Exception $e) {
                \Log::error('Translation failed: ' . $e->getMessage(), ['request' => $request->all()]);
                return response()->json(['error' => 'Translation failed: ' . $e->getMessage()], 500);
            }
        }

        return response()->json($translations);
    }

    public function testTranslation()
    {
        try {
            $tr = new GoogleTranslate();
            $tr->setSource('en');
            $tr->setTarget('ar');
            $translatedText = $tr->translate('Test');
            return response()->json([
                'status' => 'success',
                'message' => 'Translation API is working',
                'translatedText' => $translatedText
            ]);
        } catch (\Exception $e) {
            \Log::error('Test Translation API error', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Translation API test failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
