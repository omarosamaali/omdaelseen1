<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Explorers;
use App\Models\Report;
use App\Models\Places;
use App\Models\Regions;
use App\Models\Branches;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ChinaDiscoverController extends Controller
{
    /**
     * Display the main discovery page.
     *
     * @param int|null $id
     * @return \Illuminate\View\View
     */
    public function index($id = null)
    {
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $explorers = Explorers::all();

        $placesQuery = Places::with('mainCategory')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('status', 'active');

        if ($id) {
            $placesQuery->where('main_category_id', $id);
        }

        $places = $placesQuery->get();

        $latestPlacesQuery = Places::with('mainCategory')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('status', 'active')
            ->latest()
            ->take(5);

        if ($id) {
            $latestPlacesQuery->where('main_category_id', $id);
        }

        $latestPlaces = $latestPlacesQuery->get();

        return view('mobile.china-discovers.index', compact('banners', 'explorers', 'places', 'latestPlaces'));
    }

    /**
     * Handle AJAX request to filter explorers by region.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterExplorers(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Invalid request']);
        }

        $regionId = $request->input('region_id');

        // Query explorers based on region_id
        $explorersQuery = Explorers::query();
        if ($regionId) {
            // Filter explorers by places in the specified region
            $explorerIds = Places::where('region_id', $regionId)
                ->distinct()
                ->pluck('main_category_id');
            $explorersQuery->whereIn('id', $explorerIds);
        }
        $explorers = $explorersQuery->get();

        // Render HTML for explorers
        $html = '';
        foreach ($explorers as $explorer) {
            $html .= '<a href="' . route('all.sub-category', ['explorer_id' => $explorer->id]) . '" class="category-card explorer-link" data-explorer-id="' . $explorer->id . '">';
            $html .= '<img style="width: 100px;" class="category-card-image" src="' . asset('storage/' . $explorer->avatar) . '" alt="">';
            $html .= '<p class="category-card-text explorer-name">' . $explorer->name_ar . '</p>';
            $html .= '</a>';
        }

        if ($explorers->isEmpty()) {
            $html = '<div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">' .
                '<p style="color: #6c757d; font-size: 18px;">لا يوجد تصنيفات للعرض حاليًا.</p>' .
                '</div>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    /**
     * Handle the AJAX request to filter places.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterPlaces(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Invalid request']);
        }

        $explorerId = $request->input('explorer_id');

        // Query for main places with rating data
        $placesQuery = Places::with('mainCategory')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('status', 'active');
        if ($explorerId) {
            $placesQuery->where('main_category_id', $explorerId);
        }
        $places = $placesQuery->get();

        // Query for latest places with rating data
        $latestPlacesQuery = Places::with('mainCategory')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('status', 'active')
            ->latest();
        if ($explorerId) {
            $latestPlacesQuery->where('main_category_id', $explorerId);
        }
        $latestPlaces = $latestPlacesQuery->take(5)->get();

        // Render HTML for both sections
        $placesHtml = $this->renderPlacesHtml($places);
        $latestPlacesHtml = $this->renderPlacesHtml($latestPlaces);

        return response()->json([
            'success' => true,
            'html' => $placesHtml,
            'latest_places_html' => $latestPlacesHtml,
        ]);
    }

    /**
     * A helper method to render the places HTML to avoid code duplication.
     *
     * @param \Illuminate\Database\Eloquent\Collection $places
     * @return string
     */
    private function renderPlacesHtml($places)
    {
        if ($places->isEmpty()) {
            return '<div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">' .
                '<p style="color: #6c757d; font-size: 18px;">لا يوجد أماكن للعرض حاليًا.</p>' .
                '</div>';
        }

        $html = '';
        foreach ($places as $place) {
            $isFavorited = Auth::check() && Auth::user()->isFavorite($place);
            $heartClass = $isFavorited ? 'favorited' : '';
            $iconClass = $isFavorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
            $categoryAvatar = $place->mainCategory ? asset('storage/' . $place->mainCategory->avatar) : asset('storage/placeholders/no-category.png');
            $categoryName = $place->mainCategory ? $place->mainCategory->name_ar : 'بدون تصنيف';
            $exploreLink = route('mobile.china-discovers.info_place', $place);

            // Get the calculated rating data from the model
            $avgRating = number_format($place->ratings_avg_rating ?? 0, 1);
            $ratingsCount = $place->ratings_count ?? 0;

            $html .= '<div class="place-card">';
            $html .= '<img src="' . asset('storage/' . $place->avatar) . '" alt="' . $place->name_ar . '">';

            if (Auth::check() && Auth::id() != $place->user_id) {
                $html .= '<div class="heart-icon ' . $heartClass . '" data-place-id="' . $place->id . '">';
                $html .= '<i class="fa ' . $iconClass . '" style="font-size: 18px;"></i>';
                $html .= '</div>';
            }

            // Rating section
            $html .= '<div class="rating-icon" style="position: absolute; top: 10px; right: 53px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">';
            $html .= '<i class="fa-solid fa-star" style="font-size: 18px;"></i>';
            $html .= '<span style="font-size: 14px; font-weight: bold; color: #fff;">' . $avgRating . ' (' . $ratingsCount . ')</span>';
            $html .= '</div>';

            $html .= '<div class="category-tag">';
            $html .= '<img src="' . $categoryAvatar . '" alt="' . $categoryName . '">';
            $html .= '<span>' . $categoryName . '</span>';
            $html .= '</div>';

            $html .= '<div class="place-name">' . $place->name_ar . '</div>';
            $html .= '<a href="' . $exploreLink . '" class="explore-btn">استكشف</a>';
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Display all places, optionally filtered by region.
     *
     * @param int|null $region_id
     * @return \Illuminate\View\View
     */
    public function allPlaces($region_id = null)
    {
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $regions = Regions::all();
        $placesQuery = Places::query();
        if ($region_id) {
            $placesQuery->where('region_id', $region_id);
        }
        $mainCategoryIds = $placesQuery->distinct()->pluck('main_category_id');
        $explorers = Explorers::all();
        $sub_categories = Branches::all();
        return view('mobile.china-discovers.all-places', compact('sub_categories', 'regions', 'banners', 'explorers', 'region_id'));
    }

    /**
     * Display all sub-categories for a given explorer.
     *
     * @param int|null $explorer_id
     * @return \Illuminate\View\View
     */
    public function allSubCategory($explorer_id = null)
    {
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        $regions = Regions::all();
        $placesQuery = Places::query();
        $branches = Branches::where('main', $explorer_id)->get();
        $mainCategoryIds = $placesQuery->distinct()->pluck('main_category_id');
        $explorer = Explorers::findOrFail($explorer_id);
        return view('mobile.china-discovers.all-sub-category', compact('branches', 'regions', 'banners', 'explorer'));
    }

    /**
     * Display all places for a given branch (sub-category).
     *
     * @param int $branch_id
     * @return \Illuminate\View\View
     */
    public function allAreaPlaces($branch_id)
    {
        $branch = Branches::findOrFail($branch_id);
        $places = Places::with('region', 'mainCategory', 'subCategory')
            ->where('sub_category_id', $branch->id)
            ->get();
        $banners = Banner::where('location', 'both')->orWhere('location', 'mobile_app')->get();
        return view('mobile.china-discovers.all-area-places', compact('banners', 'places', 'branch'));
    }

    /**
     * Show the form for creating a new place.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $explorers = Explorers::all();
        $regions = Regions::all();
        return view('mobile.china-discovers.create', compact('explorers', 'regions'));
    }

    /**
     * Store a newly created place.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Show the form for editing a place.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
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

    /**
     * Update a place.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Get subcategories for a given explorer.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubcategories($id)
    {
        $subcategories = Branches::where('main', $id)->get();
        return response()->json($subcategories);
    }

    /**
     * Translate text using Google Translate.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Test the translation API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
