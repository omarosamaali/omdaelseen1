<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country' => ['required', 'string', 'max:2'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // Generate a 6-digit OTP
        $otp = Str::random(6, '0123456789');

        // Create the user but don't log them in yet
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $otp,
        ]);

        // Send OTP to the user's email
    Mail::raw("Your OTP for registration is: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Your OTP for Registration');
        });

        // Store user ID in session to use in OTP verification
        $request->session()->put('pending_user_id', $user->id);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify');
    }

    /**
     * Display the OTP verification form.
     */
    public function showOtpForm(Request $request): View|RedirectResponse
    {
        // Check if there’s a pending user in the session
        if (!$request->session()->has('pending_user_id')) {
            return redirect()->route('register');
        }

        return view('auth.otp-verify');
    }

    /**
     * Handle OTP verification.
     */
/**
 * Handle OTP verification.
 */
public function verifyOtp(Request $request): RedirectResponse
{
    $request->validate([
        'otp' => ['required', 'string', 'size:6'],
    ]);

    // Get the pending user ID from the session
    $userId = $request->session()->get('pending_user_id');
    $user = User::find($userId);

    if (!$user) {
        return back()->withErrors(['otp' => 'Invalid session. Please register again.']);
    }

    // Verify the OTP
    if ($user->otp !== $request->otp) {
        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    // Clear the OTP, update status to active (1), and session
    $user->otp = null;
    $user->status = 1; // تغيير الحالة إلى active
    $user->save();
    
    $request->session()->forget('pending_user_id');

    // Trigger the Registered event and log the user in
    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('home');
}

}
