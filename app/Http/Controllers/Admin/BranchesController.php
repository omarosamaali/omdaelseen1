<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Explorers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchesController extends Controller
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
        $query = Branches::query();

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

        $branches = $query->withCount('places')->paginate(10);
        $currentFilter = $request->filter;

        return view('admin.omdaHome.branches.index', compact('branches', 'currentFilter'))
            ->with('layout', $this->layout);
    }

    public function create()
    {
        $explorers = Explorers::all(['id', 'name_ar']);
        $mainCategories = Explorers::all(['id', 'name_ar']);
        return view('admin.omdaHome.branches.create', compact('explorers', 'mainCategories'))
            ->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:explorers,id',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['status'] = $data['status'] === 'نشط' ? 'active' : 'inactive';
        $data['main'] = $request->input('parent_id', null);

        Branches::create($data);

        return redirect()->route('admin.branches.index')->with('success', 'تم إضافة التصنيف الفرعي بنجاح');
    }

    public function edit($id)
    {
        $branch = Branches::findOrFail($id);
        $explorers = Explorers::all(['id', 'name_ar']);
        $mainCategories = Explorers::all(['id', 'name_ar']);
        return view('admin.omdaHome.branches.edit', compact('branch', 'explorers', 'mainCategories'))
            ->with('layout', $this->layout);
    }

    public function update(Request $request, $id)
    {
        $branch = Branches::findOrFail($id);

        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ch' => 'required|string|max:255',
            'status' => 'required|in:نشط,غير نشط',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:explorers,id',
        ]);

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validatedData['status'] = $this->normalizeStatus($validatedData['status']);
        $validatedData['main'] = $request->input('parent_id', null);

        $branch->update($validatedData);

        return redirect()->route('admin.branches.index')->with('success', 'تم تحديث التصنيف الفرعي بنجاح');
    }

    private function normalizeStatus($status)
    {
        return in_array($status, ['نشط', 'active']) ? 'active' : 'inactive';
    }

    public function show($id)
    {
        $branch = Branches::findOrFail($id);
        return view('admin.omdaHome.branches.show', compact('branch'))
            ->with('layout', $this->layout);
    }

    public function destroy($id)
    {
        $branch = Branches::findOrFail($id);
        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'تم حذف التصنيف الفرعي بنجاح');
    }
}