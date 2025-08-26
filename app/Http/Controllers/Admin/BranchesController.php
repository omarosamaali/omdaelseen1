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
        $query = Branches::with(['explorer', 'parent']);

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
        // الحصول على التصنيفات الفرعية الرئيسية (التي ليس لها parent_id)
        $parentBranches = Branches::whereNull('parent_id')->get(['id', 'name_ar', 'main']);

        return view('admin.omdaHome.branches.create', compact('explorers', 'parentBranches'))
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
            'main' => 'required|exists:explorers,id', // التصنيف الرئيسي (Explorer)
            'parent_id' => 'nullable|exists:branches,id', // التصنيف الفرعي الأب
        ]);

        // التحقق من أن parent_id يجب أن يكون من نفس التصنيف الرئيسي
        if ($request->parent_id) {
            $parentBranch = Branches::find($request->parent_id);
            if (!$parentBranch || $parentBranch->main != $request->main) {
                return back()->withErrors(['parent_id' => 'التصنيف الفرعي الأب يجب أن يكون من نفس التصنيف الرئيسي'])->withInput();
            }
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['status'] = $data['status'] === 'نشط' ? 'active' : 'inactive';

        Branches::create($data);

        return redirect()->route('admin.branches.index')->with('success', 'تم إضافة التصنيف الفرعي بنجاح');
    }

    public function edit($id)
    {
        $branch = Branches::findOrFail($id);
        $explorers = Explorers::all(['id', 'name_ar']);
        // الحصول على التصنيفات الفرعية التي يمكن أن تكون آباء (باستثناء التصنيف الحالي وأطفاله)
        $parentBranches = Branches::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get(['id', 'name_ar', 'main']);

        return view('admin.omdaHome.branches.edit', compact('branch', 'explorers', 'parentBranches'))
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
            'main' => 'required|exists:explorers,id',
            'parent_id' => 'nullable|exists:branches,id',
        ]);

        // التحقق من أن parent_id يجب أن يكون من نفس التصنيف الرئيسي
        if ($request->parent_id) {
            $parentBranch = Branches::find($request->parent_id);
            if (!$parentBranch || $parentBranch->main != $request->main) {
                return back()->withErrors(['parent_id' => 'التصنيف الفرعي الأب يجب أن يكون من نفس التصنيف الرئيسي'])->withInput();
            }

            // التحقق من عدم إنشاء حلقة مفرغة
            if ($this->wouldCreateCircularReference($id, $request->parent_id)) {
                return back()->withErrors(['parent_id' => 'لا يمكن جعل هذا التصنيف أب لنفسه أو لأحد آبائه'])->withInput();
            }
        }

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validatedData['status'] = $this->normalizeStatus($validatedData['status']);

        $branch->update($validatedData);

        return redirect()->route('admin.branches.index')->with('success', 'تم تحديث التصنيف الفرعي بنجاح');
    }

    private function normalizeStatus($status)
    {
        return in_array($status, ['نشط', 'active']) ? 'active' : 'inactive';
    }

    private function wouldCreateCircularReference($branchId, $parentId)
    {
        $currentParentId = $parentId;

        while ($currentParentId) {
            if ($currentParentId == $branchId) {
                return true; // حلقة مفرغة
            }

            $parent = Branches::find($currentParentId);
            $currentParentId = $parent ? $parent->parent_id : null;
        }

        return false;
    }
    public function getByExplorer($explorerId)
    {
        $branches = Branches::where('explorer_id', $explorerId)->get(['id', 'name_ar']);
        return response()->json($branches);
    }
    public function show($id)
    {
        $branch = Branches::with(['explorer', 'parent', 'children'])->findOrFail($id);
        return view('admin.omdaHome.branches.show', compact('branch'))
            ->with('layout', $this->layout);
    }

    public function destroy($id)
    {
        $branch = Branches::findOrFail($id);

        // التحقق من وجود تصنيفات فرعية تابعة
        if ($branch->children()->exists()) {
            return back()->with('error', 'لا يمكن حذف هذا التصنيف لأن له تصنيفات فرعية تابعة');
        }

        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'تم حذف التصنيف الفرعي بنجاح');
    }

    // API للحصول على التصنيفات الفرعية بناء على التصنيف الرئيسي
    public function getBranchesByExplorer($explorerId)
    {
        $branches = Branches::where('main', $explorerId)
            ->get(['id', 'name_ar', 'parent_id']);
        return response()->json($branches);
    }

    // API للحصول على التصنيفات الفرعية الفرعية بناء على التصنيف الفرعي الأب
    public function getSubBranches($parentId)
    {
        $subBranches = Branches::where('parent_id', $parentId)
            ->get(['id', 'name_ar']);

        return response()->json($subBranches);
    }
}
