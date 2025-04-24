<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Explorers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExplorersController extends Controller
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
        $query = Explorers::query();

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
            }
        }

        // Fetch explorers with pagination
        $explorers = $query->paginate(10);
        $currentFilter = $request->filter;

        return view('admin.omdaHome.explorers.index', compact('explorers'))
            ->with('layout', $this->layout);
    }

    public function create()
    {
        return view('admin.omdaHome.explorers.create')->with('layout', $this->layout);
    }

public function store(Request $request)
{
    $data = $request->validate([
        'name_ar' => 'required|string|max:255',
        'name_en' => 'required|string|max:255',
        'name_ch' => 'required|string|max:255',
        'status' => 'required|in:نشط,غير نشط',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('avatar')) {
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    Explorers::create($data);

    return redirect()->route('admin.explorers.index')->with('success', 'تم إضافة المستكشف بنجاح');
}

public function update(Request $request, $id)
{
    $explorer = Explorers::findOrFail($id);

    $data = $request->validate([
        'name_ar' => 'required|string|max:255',
        'name_en' => 'required|string|max:255',
        'name_ch' => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('avatar')) {
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    } else {
        unset($data['avatar']);
    }

    $explorer->update($data);

    return redirect()->route('admin.explorers.index')->with('success', 'تم تحديث المستكشف بنجاح');
}

    public function edit($id)
    {
        $explorer = Explorers::findOrFail($id);
        return view('admin.omdaHome.explorers.edit', compact('explorer'))->with('layout', $this->layout);
    }

    public function show($id)
    {
        $explorer = Explorers::findOrFail($id);
        return view('admin.omdaHome.explorers.show', compact('explorer'))->with('layout', $this->layout);
    }

    public function destroy($id)
    {
        $explorer = Explorers::findOrFail($id);
        $explorer->delete();
        return redirect()->route('admin.explorers.index')->with('success', 'تم حذف المستكشف بنجاح');
    }
}