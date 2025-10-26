<?php

namespace App\Http\Controllers;

use App\Models\OrderMessage;
use App\Models\Product;
use App\Models\TripRequest;
use App\Models\UnpaidTripRequests;
use App\Models\TripRegistration;
use App\Models\TravelChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatOrderController extends Controller
{ // أضف هذه الـ Methods في ChatOrderController

    /**
     * عرض الرسائل للمستخدم
     */
    public function userTripMessages($order_id, $order_type)
    {
        // تحديد الموديل بناءً على order_type
        $orderModel = match ($order_type) {
            'unpaid' => UnpaidTripRequests::class,
            'registration' => TripRegistration::class,
            'trip_request' => TripRequest::class,
            default => abort(404, 'نوع الطلب غير صحيح')
        };

        // جلب جميع الرسائل
        $messages = TravelChat::query()
            ->where('order_id', $order_id)
            ->where('order_type', $orderModel)
            ->with(['user'])
            ->orderBy('created_at', 'asc')
            ->get();

        // جلب الطلب المناسب
        $order = $orderModel::findOrFail($order_id);

        return view('mobile.profile.actions.user-trip-messages', compact(
            'messages',
            'order_id',
            'order',
            'order_type'
        ));
    }

    /**
     * إرسال رسالة من المستخدم
     */
    public function sendUserTripMessage(Request $request)
    {
        \Log::info('sendUserTripMessage called', $request->all());

        $request->validate([
            'order_id' => 'required|integer',
            'order_type' => 'required|string|in:unpaid,registration,trip_request',
            'message' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ]);

        // تحديد الموديل الصحيح
        $orderModel = match ($request->order_type) {
            'unpaid' => UnpaidTripRequests::class,
            'registration' => TripRegistration::class,
            'trip_request' => TripRequest::class,
        };

        // تأكد إن الـ order موجود
        $order = $orderModel::findOrFail($request->order_id);

        $filePath = null;
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('chat_images', 'public');
        }

        $message = TravelChat::create([
            'order_id' => $request->order_id,
            'order_type' => $orderModel,
            'trip_id' => $order->trip_id ?? null,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'image' => $filePath,
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'image' => $message->image,
                'created_at' => $message->created_at->toDateTimeString(),
                'user' => [
                    'role' => Auth::user()->role,
                ],
            ]
        ]);
    }
    public function userAdminChatTrip($trip_id)
    {
        $trip = TripRequest::findOrFail($trip_id);
        return view('mobile.profile.actions.userAdminChatTrip', compact('trip_id', 'trip'));
    }

    public function userAdminChat($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('mobile.profile.actions.userAdminChat', compact('product_id', 'product'));
    }

    public function userChat($product_id)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized');
        }
        $product = Product::findOrFail($product_id);
        return view('mobile.profile.actions.user-chat', compact('product_id', 'product'));
    }

    public function adminChat($product_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $product = Product::findOrFail($product_id);
        return view('mobile.profile.actions.admin-chat', compact('product_id', 'product'));
    }

    public function adminChatTrip($trip_id)
    {
        $trip = TripRequest::find($trip_id)
            ?? UnpaidTripRequests::find($trip_id)
            ?? TripRegistration::find($trip_id);

        if (!$trip) abort(404, 'الرحلة غير موجودة');

        $messages = TravelChat::where('order_id', $trip_id)
            ->where('order_type', get_class($trip))
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mobile.profile.actions.admin-chat-trip', compact('trip_id', 'trip', 'messages'));
    }

    // ✅ الـ method الأصلية للمستخدم
    public function sendMessage(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'order_type' => 'required|string',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'order_id' => $request->order_id,
            'order_type' => $request->order_type,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('chat_images', 'public');
        }

        $message = TravelChat::create($data);

        return response()->json(['message' => $message]);
    }

    // ✅ NEW: method خاصة بإرسال رسائل الـ trip من الأدمن
    public function sendTripMessage(Request $request)
    {
        \Log::info('sendTripMessage called from ChatOrderController', $request->all());

        // ✅ التعامل مع trip_id أو order_id
        $orderId = $request->trip_id ?? $request->order_id;
        $orderType = $request->order_type;

        $request->validate([
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!$orderId) {
            return response()->json(['error' => 'معرف الطلب مطلوب'], 400);
        }

        // ✅ تحديد الموديل الصحيح
        if ($orderType) {
            $orderModel = match ($orderType) {
                'unpaid' => UnpaidTripRequests::class,
                'registration' => TripRegistration::class,
                'trip_request' => TripRequest::class,
                default => null
            };
        } else {
            // جرب تلاقي الـ order
            $order = TripRequest::find($orderId)
                ?? UnpaidTripRequests::find($orderId)
                ?? TripRegistration::find($orderId);

            if (!$order) {
                return response()->json(['error' => 'الطلب غير موجود'], 404);
            }

            $orderModel = get_class($order);
        }

        if (!$orderModel) {
            return response()->json(['error' => 'نوع الطلب غير صحيح'], 400);
        }

        // تأكد إن الـ order موجود
        $order = $orderModel::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'الطلب غير موجود'], 404);
        }

        $filePath = null;
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('chat_images', 'public');
        }

        $message = TravelChat::create([
            'order_id' => $orderId,
            'order_type' => $orderModel,
            'trip_id' => $order->trip_id ?? null,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'image' => $filePath,
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'image' => $message->image,
                'created_at' => $message->created_at->toDateTimeString(),
                'user' => [
                    'role' => Auth::user()->role,
                ],
            ]
        ]);
    }
}
