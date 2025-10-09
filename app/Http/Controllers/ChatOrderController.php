<?php

namespace App\Http\Controllers;

use App\Models\OrderMessage;
use App\Models\Product;
use App\Models\TripRequest;
use App\Models\TravelChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatOrderController extends Controller
{
    public function userAdminChatTrip($trip_id)
    {

        $trip = TripRequest::findOrFail($trip_id); // جلب بيانات المنتج
        return view('mobile.profile.actions.userAdminChatTrip', compact('trip_id', 'trip'));
    }

    public function userAdminChat($product_id)
    {
        
        $product = Product::findOrFail($product_id); // جلب بيانات المنتج
        return view('mobile.profile.actions.userAdminChat', compact('product_id', 'product'));
    } 
    
    public function userChat($product_id)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized');
        }
        $product = Product::findOrFail($product_id); // جلب بيانات المنتج
        return view('mobile.profile.actions.user-chat', compact('product_id', 'product'));
    }

    public function adminChat($product_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $product = Product::findOrFail($product_id); // جلب بيانات المنتج
        return view('mobile.profile.actions.admin-chat', compact('product_id', 'product'));
    }

    public function adminChatTrip($trip_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $trip = TripRequest::findOrFail($trip_id); // جلب بيانات المنتج
        return view('mobile.profile.actions.admin-chat-trip', compact('trip_id', 'trip'));
    }
    
    public function sendMessage(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('chat_images', 'public');
        }

        $message = OrderMessage::create($data);

        return response()->json([
            'message' => $message
        ]);
    }
}
