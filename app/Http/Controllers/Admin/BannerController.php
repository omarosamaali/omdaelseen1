<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.omdaHome.banners.index', compact('banners'))->with('layout', $this->layout);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.omdaHome.banners.create')->with('layout', $this->layout);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'title_ar' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'title_zh' => 'required|string|max:255',
        'location' => 'required|in:website_home,mobile_app,both',
        'is_active' => 'required|in:نشط,غير نشط',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $bannerData = $request->only([
        'title_ar',
        'title_en',
        'title_zh',
        'location',
        'is_active',
        'start_date',
        'end_date',
    ]);

    // Handle file upload
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('banners', 'public');
        $bannerData['avatar'] = $path;
    }

    Banner::create($bannerData);

    return redirect()->route('admin.banners.index')->with('success', 'تم إضافة البنر بنجاح');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.omdaHome.banners.show', compact('banner'))->with('layout', $this->layout);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.omdaHome.banners.edit', compact('banner'))->with('layout', $this->layout);
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $request->validate([
        'title_ar' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'title_zh' => 'required|string|max:255',
        'location' => 'required|in:website_home,mobile_app,both',
        'is_active' => 'required|in:نشط,غير نشط',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $banner = Banner::findOrFail($id);

    $bannerData = $request->only([
        'title_ar',
        'title_en',
        'title_zh',
        'location',
        'is_active',
        'start_date',
        'end_date',
    ]);

    // Handle file upload
    if ($request->hasFile('avatar')) {
        // Delete old image if exists
        if ($banner->avatar) {
            Storage::disk('public')->delete($banner->avatar);
        }
        $path = $request->file('avatar')->store('banners', 'public');
        $bannerData['avatar'] = $path;
    }

    $banner->update($bannerData);

    return redirect()->route('admin.banners.index')->with('success', 'تم تحديث البنر بنجاح');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        // Delete the image if exists
        if ($banner->avatar) {
            Storage::disk('public')->delete($banner->avatar);
        }

        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'تم حذف البنر بنجاح');
    }

    /**
     * Remove the image from the banner.
     */
    public function deleteImage(Request $request)
    {
        $banner = Banner::findOrFail($request->banner_id);

        if ($banner->avatar) {
            Storage::disk('public')->delete($banner->avatar);
            $banner->avatar = null;
            $banner->save();
        }

        return response()->json(['success' => true]);
    }
}