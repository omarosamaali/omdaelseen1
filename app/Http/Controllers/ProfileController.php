<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $layout = Auth::check() && Auth::user()->role === 'admin' ? 'layouts.appProfileAdmin' : 'layouts.appProfile';
        return view('profile.edit', [
            'user' => $request->user(),
            'layout' => $layout,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => ['nullable', 'image', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:2'],
        ]);
        $user = $request->user();
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        $user->update([
            'phone' => $request->phone,
            'country' => $request->country,
        ]);
        return back()->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
}
