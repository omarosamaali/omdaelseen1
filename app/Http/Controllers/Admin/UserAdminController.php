<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rating;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserAdminController extends Controller
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
        $query = User::query();

        // Handle search
        if ($request->has('user_search') && $request->user_search) {
            $query->where('name', 'like', '%' . $request->user_search . '%');
        }

        // Handle filtering
        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter === 'admin') {
                $query->where('role', 'admin');
            } elseif ($filter === 'user') {
                $query->where('role', 'user');
            } elseif ($filter === 'active') {
                $query->where('status', 1);
            } elseif ($filter === 'inactive') {
                $query->where('status', 0);
            } elseif ($filter === 'banned') {
                $query->where('status', 2);
            }
        }

        $users = $query->withCount('places', 'favorites', 'ratings', 'trips')->paginate(10);
        $adminsCount = User::where('role', 'admin')->count();
        $usersCount = User::where('role', 'user')->count();
        $activeUsersCount = User::where('status', 1)->count();
        $inactiveUsersCount = User::where('status', 0)->count();
        $bannedUsersCount = User::where('status', 2)->count(); // Fixed inconsistency
        $deletedUsersCount = User::onlyTrashed()->count();

        $currentFilter = $request->filter;
        $ratings_count = Rating::where('user_id', Auth::user()->id)->count();
        $trips_count = Trip::where('user_id', Auth::user()->id)->count(); // إضافة count()
        return view('admin.omdaHome.users.index', compact('trips_count','users', 'adminsCount', 'usersCount', 'activeUsersCount', 'inactiveUsersCount', 'bannedUsersCount', 'deletedUsersCount', 'currentFilter'))
            ->with('layout', $this->layout);
    }

    public function create()
    {
        return view('admin.omdaHome.users.create')->with('layout', $this->layout);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users',
            'country' => 'nullable|string|max:2',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:0,1,2',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit($id)
    {
        $usser = User::findOrFail($id);
        return view('admin.omdaHome.users.edit', compact('usser'))->with('layout', $this->layout);
    }

    public function editFromMobile($ad)
    {
        $userad = User::findOrFail($ad);
        return view('mobile.admin.users.edit', compact('userad'));
    }

    public function updateFromMobile(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'country' => 'nullable|string|max:2',
            'status' => 'required|in:0,1,2,3',
            'password' => 'nullable|string|min:8|confirmed',
            'explorer_name' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('mobile.admin.users.index')->with('success', 'تم تحديث المستخدم بنجاح!');
    }

    public function destroyFromMobile(User $user)
    {
        $user->delete();
        return redirect()->route('mobile.admin.users.index')->with('success', 'تم حذف المستخدم بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'country' => 'nullable|string|max:2',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:0,1,2',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'تم التحديث بنجاح');
    }

    public function show($id)
    {
        $usser = User::with(['places' => function ($query) {
            $query->with(['mainCategory', 'subCategory', 'region']);
        }])->findOrFail($id);

        return view('admin.omdaHome.users.show', compact('usser'))->with('layout', $this->layout);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
