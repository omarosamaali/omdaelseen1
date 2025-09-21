<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function showUserChat()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            \Log::error('No admin found');
            abort(404, 'Admin not found');
        }

        $messages = Message::where(function ($query) use ($admin) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $admin->id)
                ->orWhere('sender_id', $admin->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        \Log::info('User chat messages', [
            'user_id' => Auth::id(),
            'admin_id' => $admin->id,
            'messages' => $messages->toArray()
        ]);

        return view('mobile.chat', compact('messages', 'admin'));
    }
    public function showAdminChat(User $chatUser)
    {
        \Log::info('showAdminChat called', [
            'admin_id' => Auth::id(),
            'user_id' => $chatUser->id,
            'user_name' => $chatUser->name
        ]);

        $messages = Message::where(function ($query) use ($chatUser) {
            $query->where('sender_id', $chatUser->id)->where('receiver_id', Auth::id())
                ->orWhere('sender_id', Auth::user()->id)->where('receiver_id', $chatUser->id);
        })->orderBy('created_at', 'asc')->get();

        \Log::info('Admin chat messages', [
            'admin_id' => Auth::id(),
            'user_id' => $chatUser->id,
            'messages' => $messages->toArray()
        ]);

        return view('mobile.admin.chat', compact('messages', 'chatUser'));
    }
    public function showAllChats()
    {
        if (!Auth::user()->role === 'admin') {
            abort(403, 'Unauthorized');
        }

        $users = User::where('role', 'user')->get();
        $chats = [];

        foreach ($users as $user) {
            $lastMessage = Message::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)->where('receiver_id', Auth::id())
                    ->orWhere('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orderBy('created_at', 'desc')->first();

            $chats[] = [
                'user' => $user,
                'last_message' => $lastMessage ? ($lastMessage->message ?? ($lastMessage->image ? 'Image' : 'No content')) : 'No messages yet',
                'last_message_date' => $lastMessage ? $lastMessage->created_at->format('d M') : null,
            ];
        }

        \Log::info('Admin chats', ['chats' => $chats]);

        return view('mobile.admin.all-chat', compact('chats'));
    }
    public function sendMessage(Request $request)
    {
        try {
            \Log::info('Received sendMessage request', [
                'sender_id' => Auth::id(),
                'sender_role' => Auth::user()->role,
                'input' => $request->all()
            ]);

            $request->validate([
                'message' => 'nullable|string',
                'receiver_id' => 'required|exists:users,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if (Auth::id() == $request->receiver_id) {
                \Log::warning('Attempt to send message to self', [
                    'sender_id' => Auth::id(),
                    'receiver_id' => $request->receiver_id,
                    'message' => $request->message
                ]);
                return response()->json(['error' => 'Cannot send message to yourself'], 400);
            }

            $data = [
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ];

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chat_images', 'public');
                $data['image'] = $imagePath;
            }

            $message = Message::create($data);

            \Log::info('Message saved successfully', [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'image' => $message->image
            ]);

            return response()->json(['status' => 'Message sent', 'message' => $message]);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage(), [
                'sender_id' => Auth::id(),
                'input' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to send message: ' . $e->getMessage()], 500);
        }
    }
}
