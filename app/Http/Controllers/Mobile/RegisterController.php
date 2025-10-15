<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
                'phone' => ['nullable', 'string', 'max:255', 'unique:users'],
                'country' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'terms' => ['required', 'accepted'],
            ],
            // You can add custom validation messages here
            [
                'terms.required' => 'يجب الموافقة على الشروط والأحكام.',
                'terms.accepted' => 'يجب الموافقة على الشروط والأحكام.',
            ]
        );

        // 2. Generate a unique explorer name before creating the user
        do {
            $randomNumber = random_int(1000, 9999); // Generate a random 4-digit number
            $explorerName = $randomNumber;
        } while (User::where('explorer_name', $explorerName)->exists()); // Check if the name already exists

        // 3. Create the new user in the database with the generated name
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'explorer_name' => $explorerName, // This is the new line
        ]);

        // 4. Log the new user in
        Auth::login($user);

        // 5. Redirect the user to the welcome page
        return redirect()->route('mobile.welcome');
    }
}
