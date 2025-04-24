<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionsController extends Controller
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
        $query = Regions::query();
        if ($request->has('user_search') && $request->user_search) {
            $query->where('name_ar', 'like', '%' . $request->user_search . '%')
                ->orWhere('name_en', 'like', '%' . $request->user_search . '%')
                ->orWhere('name_ch', 'like', '%' . $request->user_search . '%');
        }
        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter === 'active') {
                $query->where('status', 'active');
            }
        }
        $regions = $query->paginate(999999);
        $currentFilter = $request->filter;
        return view('admin.omdaHome.regions.index', compact('regions', 'currentFilter'))
            ->with('layout', $this->layout);
    }

    public function create()
    {
        return view('admin.omdaHome.regions.create')->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'places' => 'integer|min:0',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        Regions::create($data);

        return redirect()->route('admin.regions.index')->with('success', 'تم إضافة المنطقة بنجاح');
    }

    public function edit($id)
    {
        $region = Regions::findOrFail($id);
        return view('admin.omdaHome.regions.edit', compact('region'))->with('layout', $this->layout);
    }

    public function update(Request $request, $id)
    {
        $regions = Regions::findOrFail($id);

        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'places' => 'integer|min:0',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($data['avatar']); // Keep existing avatar if no new file is uploaded
        }

        $regions->update($data);

        return redirect()->route('admin.regions.index')->with('success', 'تم تحديث المنطقة بنجاح');
    }

    public function show($id)
    {
        $region = Regions::findOrFail($id);
        return view('admin.omdaHome.regions.show', compact('region'))->with('layout', $this->layout);
    }

    public function destroy($id)
    {
        $explorer = Regions::findOrFail($id);
        $explorer->delete();
        return redirect()->route('admin.regions.index')->with('success', 'تم حذف المنطقة بنجاح');
    }
}