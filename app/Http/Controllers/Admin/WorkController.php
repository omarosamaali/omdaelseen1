<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    protected $layout;

    /**
     * Display a listing of the resource.
     */
       public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }
public function index()
{
    $works = Work::orderBy('created_at', 'desc')->get();
    return view('admin.omdaHome.works.index', compact('works'))->with('layout', $this->layout);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.omdaHome.works.create')->with('layout', $this->layout);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
$request->validate([
    'content_ar' => 'required|max:1000000', // Adjust the max length as needed
    'content_en' => 'nullable|max:1000000',
    'content_zh' => 'nullable|max:1000000',
    'title_ar' => 'nullable',
    'title_en' => 'nullable',
    'title_zh' => 'nullable',
    'status' => 'required|in:نشط,غير نشط',
    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);

        $workData = $request->only([
            'content_ar', 'content_en', 'content_zh',
            'title_ar', 'title_en', 'title_zh',
            'status'
        ]);

        // Handle file upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('works', 'public');
            $workData['avatar'] = $path;
        }

        Work::create($workData);

        return redirect()->route('admin.works.index')->with('success', 'تم إضافة العمل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $work = Work::findOrFail($id);
        return view('admin.omdaHome.works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $work = Work::findOrFail($id);
        return view('admin.omdaHome.works.edit', compact('work'))->with('layout', $this->layout);;
    }

    /**
     * Update the specified resource in storage.
     */

     
    public function update(Request $request, string $id)
    {
        $request->validate([
            'content_ar' => 'required',
            'content_en' => 'nullable',
            'content_zh' => 'nullable',
            'title_ar' => 'nullable',
            'title_en' => 'nullable',
            'title_zh' => 'nullable',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $work = Work::findOrFail($id);
        
        $workData = $request->only([
            'content_ar', 'content_en', 'content_zh',
            'title_ar', 'title_en', 'title_zh',
            'status'
        ]);

        // Handle file upload
        if ($request->hasFile('avatar')) {
            // Delete old image if exists
            if ($work->avatar) {
                Storage::disk('public')->delete($work->avatar);
            }
            $path = $request->file('avatar')->store('works', 'public');
            $workData['avatar'] = $path;
        }

        $work->update($workData);

        return redirect()->route('admin.works.index')->with('success', 'تم تحديث العمل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $work = Work::findOrFail($id);
        
        // Delete the image if exists
        if ($work->avatar) {
            Storage::disk('public')->delete($work->avatar);
        }
        
        $work->delete();
        return redirect()->route('admin.works.index')->with('success', 'تم حذف العمل بنجاح');
    }

    /**
     * Remove the image from the work.
     */
    public function deleteImage(Request $request)
    {
        $work = Work::findOrFail($request->work_id);
        
        if ($work->avatar) {
            Storage::disk('public')->delete($work->avatar);
            $work->avatar = null;
            $work->save();
        }
        
        return response()->json(['success' => true]);
    }
}