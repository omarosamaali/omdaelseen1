<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TripRegistrationController extends Controller
{
    public function quickRegisterAndPay(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'trip_id' => 'required|exists:trips,id',
                'room_type' => 'nullable|string|in:shared,private',
            ], [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً',
                'phone.required' => 'رقم الهاتف مطلوب',
                'trip_id.exists' => 'الرحلة غير موجودة',
            ]);

            $trip = Trip::findOrFail($request->trip_id);

            return DB::transaction(function () use ($request, $trip) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make(Str::random(16)),
                    'status' => 1,
                    'email_verified_at' => now(),
                    'country' => 'EG'
                ]);
                Auth::login($user);

                $selectedRoom = $request->room_type ?? 'shared';
                session(['selected_room_type' => $selectedRoom]);

                // حساب السعر حسب نوع الغرفة
                $basePrice = ($selectedRoom === 'shared') ? ($trip->shared_room_price ?? $trip->price)
                    : (($selectedRoom === 'private') ? ($trip->private_room_price ?? $trip->price) : $trip->price);

                // إضافة 2.9% رسوم بوابة الدفع
                $feePercent = 0.029;
                $totalPrice = $basePrice * (1 + $feePercent);

                Log::info('Quick registration successful', [
                    'user_id' => $user->id,
                    'trip_id' => $trip->id,
                    'email' => $user->email,
                    'selected_room' => $selectedRoom,
                    'base_price' => $basePrice,
                    'total_price_with_fee' => $totalPrice,
                ]);

                // مرر السعر الإجمالي مباشرة
                return $this->redirectToPayment($trip, $totalPrice);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Quick registration failed', [
                'error' => $e->getMessage(),
                'trip_id' => $request->trip_id ?? 'unknown'
            ]);
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ، يرجى المحاولة مرة أخرى');
        }
    }


    public function submitRegistration(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'trip_id' => 'required|exists:trips,id',
                'room_type' => 'nullable|string|in:shared,private',
                'selected_price' => 'nullable|numeric|min:0', // السعر المحسوب من الفرونت إند
            ], [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً',
                'phone.required' => 'رقم الهاتف مطلوب',
                'trip_id.exists' => 'الرحلة غير موجودة',
            ]);

            $trip = Trip::findOrFail($request->trip_id);

            return DB::transaction(function () use ($request, $trip) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make(Str::random(16)),
                    'status' => 1,
                    'email_verified_at' => now(),
                    'country' => $request->country ?? 'EG'
                ]);

                Auth::login($user);

                // تحديد نوع الغرفة والسعر
                $selectedRoom = $request->room_type ?? 'shared';
                session(['selected_room_type' => $selectedRoom]);

                // استخدام السعر المحسوب من الفرونت إند أو حسابه هنا
                $totalPrice = $request->selected_price;

                // إذا لم يكن السعر موجود، احسبه مرة أخرى
                if (!$totalPrice) {
                    $basePrice = $this->getRoomPrice($trip, $selectedRoom);
                    $feePercent = 0.029; // 2.9%
                    $totalPrice = $basePrice * (1 + $feePercent);
                }

                Log::info('Quick registration successful', [
                    'user_id' => $user->id,
                    'trip_id' => $trip->id,
                    'email' => $user->email,
                    'selected_room' => $selectedRoom,
                    'total_price_with_fee' => $totalPrice,
                ]);

                // مرر السعر الإجمالي مباشرة إلى الدفع
                return $this->redirectToPayment($trip, $totalPrice, $selectedRoom);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Quick registration failed', [
                'error' => $e->getMessage(),
                'trip_id' => $request->trip_id ?? 'unknown'
            ]);
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ، يرجى المحاولة مرة أخرى');
        }
    }

    /**
     * دالة مساعدة لحساب سعر الغرفة
     */
    private function getRoomPrice($trip, $roomType)
    {
        if ($trip->private_room_price && $roomType) {
            switch ($roomType) {
                case 'shared':
                    return $trip->shared_room_price ?? $trip->price;
                case 'private':
                    return $trip->private_room_price;
                default:
                    return $trip->price;
            }
        }

        return $trip->price;
    }
// في الـ Controller اللي بيعالج submitRegistration
private function redirectToPayment($trip, $totalPrice, $roomType = null)
{
    Log::info('Redirecting to payment', [
        'trip_id' => $trip->id,
        'total_price' => $totalPrice,
        'room_type' => $roomType
    ]);

    // تمرير السعر النهائي ونوع الغرفة كـ query parameters
    return redirect()->route('trip.payment', [
        'id' => $trip->id
    ])->with([
        'total_price' => $totalPrice,
        'room_type' => $roomType
    ]);
}

// أو إذا كنت بتستخدم GET parameters:
// private function redirectToPayment($trip, $totalPrice, $roomType = null)
// {
//     Log::info('Redirecting to payment', [
//         'trip_id' => $trip->id,
//         'total_price' => $totalPrice,
//         'room_type' => $roomType
//     ]);

//     return redirect()->route('trip.payment', [
//         'id' => $trip->id,
//         'total_price' => $totalPrice,
//         'room_type' => $roomType
//     ]);
// }

// في الـ route للدفع:

    public function showRegistrationForm($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        return view('mobile.auth.step2', compact('trip'));
    }
}
