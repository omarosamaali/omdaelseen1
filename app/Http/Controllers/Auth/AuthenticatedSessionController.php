<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->status == 'banned') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'حسابك محظور. يرجى التواصل مع الإدارة.',
            ]);
        }

        if ($user->status == 'inactive') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'حسابك غير مفعل. يرجى التحقق من بريدك الإلكتروني لتفعيله.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('home', absolute: false));
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function saveFcmToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $user = auth()->user();
        $user->fcm_token = $request->token;
        $user->save();

        // الاشتراك في Topic يجب أن يتم هنا فقط
        $this->subscribeToTopic($user->fcm_token, 'all_users');

        return response()->json(['status' => 'success']);
    }

    private function subscribeToTopic($token, $topic = "all_users")
    {
        $serverKey = env('FIREBASE_SERVER_KEY'); // server key فقط
        $url = "https://iid.googleapis.com/iid/v1:batchAdd";

        $payload = [
            "to" => "/topics/{$topic}",
            "registration_tokens" => [$token],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: key={$serverKey}",
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
