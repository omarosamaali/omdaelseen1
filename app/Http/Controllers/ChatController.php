<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function showUserChat()
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            abort(404, 'Admin not found');
        }

        $messages = Message::where(function ($query) use ($admin) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $admin->id)
                ->orWhere('sender_id', $admin->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('mobile.chat', compact('messages', 'admin'));
    }

    public function showAdminChat(User $chatUser)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        Message::where('sender_id', $chatUser->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function ($query) use ($chatUser) {
            $query->where('sender_id', $chatUser->id)->where('receiver_id', Auth::id())
                ->orWhere('sender_id', Auth::id())->where('receiver_id', $chatUser->id);
        })->orderBy('created_at', 'asc')->get();

        return view('mobile.admin.chat', compact('messages', 'chatUser'));
    }

    public function showAllChatsProfile()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $users = User::where('role', 'user')->get();
        $chats = [];

        foreach ($users as $user) {
            $lastMessage = Message::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)->where('receiver_id', Auth::id())
                    ->orWhere('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orderBy('created_at', 'desc')->first();

            $unreadCount = Message::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->count();

            $chats[] = [
                'user' => $user,
                'last_message' => $lastMessage ? ($lastMessage->message ?? ($lastMessage->image ? 'Image' : 'No content')) : 'No messages yet',
                'last_message_date' => $lastMessage ? $lastMessage->created_at->format('d M') : null,
                'unread_count' => $unreadCount,
            ];
        }

        usort($chats, function ($a, $b) {
            if ($a['unread_count'] > 0 && $b['unread_count'] == 0) {
                return -1;
            } elseif ($a['unread_count'] == 0 && $b['unread_count'] > 0) {
                return 1;
            } else {
                $aDate = $a['last_message_date'] ? strtotime($a['last_message_date']) : 0;
                $bDate = $b['last_message_date'] ? strtotime($b['last_message_date']) : 0;
                return $bDate - $aDate;
            }
        });

        return view('mobile.admin.all-chat-profile', compact('chats'));
    }

    public function showAllChats()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $users = User::where('role', 'user')->get();
        $chats = [];

        foreach ($users as $user) {
            $lastMessage = Message::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)->where('receiver_id', Auth::id())
                    ->orWhere('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orderBy('created_at', 'desc')->first();

            $unreadCount = Message::where('sender_id', $user->id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->count();

            $chats[] = [
                'user' => $user,
                'last_message' => $lastMessage ? ($lastMessage->message ?? ($lastMessage->image ? 'Image' : 'No content')) : 'No messages yet',
                'last_message_date' => $lastMessage ? $lastMessage->created_at->format('d M') : null,
                'unread_count' => $unreadCount,
            ];
        }

        usort($chats, function ($a, $b) {
            if ($a['unread_count'] > 0 && $b['unread_count'] == 0) {
                return -1;
            } elseif ($a['unread_count'] == 0 && $b['unread_count'] > 0) {
                return 1;
            } else {
                $aDate = $a['last_message_date'] ? strtotime($a['last_message_date']) : 0;
                $bDate = $b['last_message_date'] ? strtotime($b['last_message_date']) : 0;
                return $bDate - $aDate;
            }
        });

        return view('mobile.admin.all-chat', compact('chats'));
    }

    public function sendMessage(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $validated = $request->validate([
                'message' => 'nullable|string',
                'receiver_id' => 'required|exists:users,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if (Auth::id() == $request->receiver_id) {
                return response()->json(['error' => 'لا يمكنك إرسال رسالة لنفسك'], 400);
            }

            if (!$request->message && !$request->hasFile('image')) {
                return response()->json(['error' => 'يجب إرسال نص أو صورة'], 400);
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

            $this->sendEmailNotifications($message);

            return response()->json([
                'status' => 'success',
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message' => $message->message,
                    'image' => $message->image,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s')
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'خطأ في البيانات المدخلة',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل إرسال الرسالة',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function sendEmailNotifications($message)
    {
        try {
            $sender = User::find($message->sender_id);
            $receiver = User::find($message->receiver_id);

            if (!$sender || !$receiver) {
                return;
            }

            $messageData = [
                'messageText' => $message->message,
                'messageImage' => $message->image ? asset('storage/' . $message->image) : null,
                'messageDate' => $message->created_at->format('Y-m-d H:i A'),
            ];

            if ($sender->role !== 'admin' && $receiver->role === 'admin') {
                $this->notifyAdmins($message, $sender, $messageData);
            } elseif ($sender->role === 'admin' && $receiver->role !== 'admin') {
                $this->notifyUser($message, $receiver, $messageData);
            }
        } catch (\Exception $e) {
            // Silent fail - don't interrupt message sending
        }
    }

    private function notifyAdmins($message, $sender, $messageData)
    {
        try {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isEmpty()) {
                return;
            }

            $timestamp = now()->timestamp;
            $counter = 1;

            foreach ($admins as $admin) {
                Mail::send('emails.admin_new_message', array_merge($messageData, [
                    'senderName' => $sender->name,
                    'senderEmail' => $sender->email,
                    'senderPhone' => $sender->phone ?? $sender->mobile ?? null,
                    'chatUrl' => route('mobile.admin.chat', $sender->id),
                ]), function ($mail) use ($admin, $timestamp, $counter) {
                    $mail->to($admin->email)
                        ->subject('💬 رسالة جديدة رقم ' . ' #' . $timestamp . '-' . $counter);
                });
                $counter++;
            }
        } catch (\Exception $e) {
            // Silent fail
        }
    }

    private function notifyUser($message, $receiver, $messageData)
    {
        try {
            Mail::send('emails.user_new_message', array_merge($messageData, [
                'userName' => $receiver->name,
                'chatUrl' => route('mobile.user.chat'),
            ]), function ($mail) use ($receiver) {
                $mail->to($receiver->email)
                    ->subject('💬 رد جديد من فريق عمدة الصين');
            });
        } catch (\Exception $e) {
            // Silent fail
        }
    }
}
