<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trip;
use App\Models\TripRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TripRegistrationController extends Controller
{
    /**
     * تسجيل سريع ودفع مباشر
     */
    public function quickRegisterAndPay(Request $request)
    {
        try {
            $trip = Trip::findOrFail($request->trip_id);

            return DB::transaction(function () use ($request, $trip) {
                $selectedRoom = $request->room_type ?? 'shared';
                session(['selected_room_type' => $selectedRoom]);

                $basePrice = $this->getRoomPrice($trip, $selectedRoom);

                // الرسوم: 7.9% + 1 درهم
                $feePercent = 7.9 / 100;
                $fixedFee = 1;
                $totalPrice = ($basePrice * (1 + $feePercent)) + $fixedFee;

                // ✅ لو المستخدم مسجل دخول
                $user = Auth::user();
                if (!$user) {
                    throw new \Exception('User not authenticated.');
                }

                // ✅ إنشاء التسجيل في قاعدة البيانات
                $registration = TripRegistration::create([
                    'user_id' => $user->id,
                    'trip_id' => $trip->id,
                    'room_type' => $selectedRoom,
                    'amount' => $totalPrice,
                    'status' => 'paid',
                    'reference_number' => 'REF' . rand(100000000, 999999999)
                                ]);

                // ✅ أرسل الـ registration_id مع الريدايركت
                return $this->redirectToPayment($trip, $totalPrice, $selectedRoom, $registration->id);
            });
        } catch (\Exception $e) {
            Log::error('Quick registration failed', [
                'error' => $e->getMessage(),
                'trip_id' => $request->trip_id ?? 'unknown'
            ]);
            return back()->with('error', 'حدث خطأ أثناء التسجيل.');
        }
    }


    /**
     * إنشاء مستخدم جديد وتسجيل الرحلة
     */
    public function submitRegistration(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'trip_id' => 'required|exists:trips,id',
                'room_type' => 'nullable|string|in:shared,private',
                'selected_price' => 'nullable|numeric|min:0',
            ]);

            $trip = Trip::findOrFail($request->trip_id);

            return DB::transaction(function () use ($request, $trip) {
                // إنشاء المستخدم
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

                // نوع الغرفة والسعر
                $selectedRoom = $request->room_type ?? 'shared';
                session(['selected_room_type' => $selectedRoom]);

                $basePrice = $this->getRoomPrice($trip, $selectedRoom);
                $feePercent = 7.9 / 100;
                $fixedFee = 1;
                $totalPrice = ($basePrice * (1 + $feePercent)) + $fixedFee;

                // إنشاء سجل في جدول التسجيلات
                $registration = TripRegistration::create([
                    'user_id' => $user->id,
                    'trip_id' => $trip->id,
                    'room_type' => $selectedRoom,
                    'amount' => $totalPrice,
                    'status' => 'paid',
                    'reference_number' => 'REF' . rand(100000000, 999999999)

                ]);
                DB::commit(); // نحفظ الترانزاكشن قبل الريدايركت

                Log::info('Trip registration created', [
                    'registration_id' => $registration->id,
                    'user_id' => $user->id,
                    'trip_id' => $trip->id,
                    'total_price' => $totalPrice,
                ]);

                // توجيه إلى بوابة الدفع
                return $this->redirectToPayment($trip, $totalPrice, $selectedRoom, $registration->id);
            });
        } catch (\Exception $e) {
            Log::error('Trip registration failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء التسجيل.');
        }
    }

    /**
     * تحديد سعر الغرفة
     */
    private function getRoomPrice($trip, $roomType)
    {
        return match ($roomType) {
            'shared' => $trip->shared_room_price ?? $trip->price,
            'private' => $trip->private_room_price ?? $trip->price,
            default => $trip->price,
        };
    }

    /**
     * التوجيه إلى الدفع
     */
    private function redirectToPayment($trip, $totalPrice, $roomType = null, $registrationId = null)
    {
        Log::info('Redirecting to payment', [
            'trip_id' => $trip->id,
            'total_price' => $totalPrice,
            'room_type' => $roomType,
            'registration_id' => $registrationId,
        ]);

        return redirect()->route('trip.payment', [
            'id' => $trip->id,
            'registration_id' => $registrationId
        ])->with([
            'total_price' => $totalPrice,
            'room_type' => $roomType
        ]);
    }

    /**
     * عرض صفحة التسجيل
     */
    public function showRegistrationForm($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        return view('mobile.auth.step2', compact('trip'));
    }
}
