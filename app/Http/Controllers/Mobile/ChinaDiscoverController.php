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
class ChinaDiscoverController extends Controller
{
    public function index($id = null)
    {
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $latestPlaces = Places::with('mainCategory')->latest()->take(5)->get();
        $explorers = Explorers::all();
        $places = Places::with('mainCategory')->where(column: 'main_category_id', $id ?? '!=', $id)->get();
        return view('mobile.china-discovers.index', compact('banners', 'explorers', 'places', 'latestPlaces'));
    }

    public function allPlaces($region_id = null)
    {
        // Fetch all banners and regions regardless of the filter
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $regions = Regions::all();

        // Start a query on the Places table
        $placesQuery = Places::query();

        // If a region is specified, filter the places by that region
        if ($region_id) {
            $placesQuery->where('region_id', $region_id);
        }

        // Get the unique main_category_id's from the filtered places
        $mainCategoryIds = $placesQuery->distinct()->pluck('main_category_id');

        // Fetch the MainCategories that correspond to the collected IDs
        $explorers = Explorers::whereIn('id', $mainCategoryIds)->get();

        // Pass all necessary variables to the view
        return view('mobile.china-discovers.all-places', compact('regions', 'banners', 'explorers', 'region_id'));
    }

    public function create()
    {
        $explorers = Explorers::all();
        $regions = Regions::all();

        return view('mobile.china-discovers.create', compact('explorers', 'regions'));
    }

    public function getSubcategories($id)
    {
        // جلب التصنيفات الفرعية التي تنتمي إلى التصنيف الرئيسي المحدد
        $subcategories = Branches::where('main', $id)->get();

        return response()->json($subcategories);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'main_category_id' => 'required|exists:explorers,id',
            'sub_category_id' => 'nullable|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'link' => 'required|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // رفع الصورة الرئيسية
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('places/avatars', 'public');
        }

        // رفع الصور الفرعية
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $image->store('places/additional', 'public');
            }
            $data['additional_images'] = json_encode($additionalImages);
        }

        // إضافة معرف المستخدم الحالي
        $data['user_id'] = Auth::id();

        // حفظ البيانات
        Places::create($data);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('mobile.china-discovers.index')->with('success', 'تم إضافة المكان بنجاح!');
    }
}
