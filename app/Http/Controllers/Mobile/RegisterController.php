<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User; // Don't forget to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view('mobile.auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the incoming request data
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'country' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'terms' => ['required', 'accepted'], // Assuming the checkbox has the name 'terms'
            ],
            // You can add custom validation messages here
            [
                'terms.required' => 'يجب الموافقة على الشروط والأحكام.',
                'terms.accepted' => 'يجب الموافقة على الشروط والأحكام.',
            ]
        );

        // 2. Create the new user in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        // 3. Log the new user in
        Auth::login($user);

        // 4. Redirect the user to the welcome page
        return redirect()->route('mobile.welcome');
    }

}
