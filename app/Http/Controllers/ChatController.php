<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            // التحقق من المصادقة أولاً
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            \Log::info('Received sendMessage request', [
                'sender_id' => Auth::id(),
                'sender_role' => Auth::user()->role,
                'input' => $request->all()
            ]);

            // Validation
            $validated = $request->validate([
                'message' => 'nullable|string',
                'receiver_id' => 'required|exists:users,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // التحقق من أن المستلم ليس المرسل نفسه
            if (Auth::id() == $request->receiver_id) {
                \Log::warning('Attempt to send message to self', [
                    'sender_id' => Auth::id(),
                    'receiver_id' => $request->receiver_id,
                    'message' => $request->message
                ]);
                return response()->json(['error' => 'لا يمكنك إرسال رسالة لنفسك'], 400);
            }

            // التحقق من وجود محتوى للرسالة
            if (!$request->message && !$request->hasFile('image')) {
                return response()->json(['error' => 'يجب إرسال نص أو صورة'], 400);
            }

            $data = [
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ];

            // رفع الصورة إذا وجدت
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chat_images', 'public');
                $data['image'] = $imagePath;
            }

            // حفظ الرسالة
            $message = Message::create($data);

            \Log::info('Message saved successfully', [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'image' => $message->image
            ]);

            // إرسال الإيميلات
            $this->sendEmailNotifications($message);

            // إرجاع JSON response
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
            \Log::error('Validation error in sendMessage', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json([
                'error' => 'خطأ في البيانات المدخلة',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage(), [
                'sender_id' => Auth::id(),
                'input' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'فشل إرسال الرسالة',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * إرسال إشعارات البريد الإلكتروني للرسائل
     */
    private function sendEmailNotifications($message)
    {
        try {
            $sender = User::find($message->sender_id);
            $receiver = User::find($message->receiver_id);

            if (!$sender || !$receiver) {
                \Log::warning('Sender or receiver not found for email notification', [
                    'message_id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id
                ]);
                return;
            }

            // تحضير بيانات الرسالة
            $messageData = [
                'messageText' => $message->message,
                'messageImage' => $message->image ? asset('storage/' . $message->image) : null,
                'messageDate' => $message->created_at->format('Y-m-d H:i A'),
            ];

            // إذا كان المرسل مستخدم عادي والمستقبل أدمن
            if ($sender->role !== 'admin' && $receiver->role === 'admin') {
                $this->notifyAdmins($message, $sender, $messageData);
            }
            // إذا كان المرسل أدمن والمستقبل مستخدم عادي
            elseif ($sender->role === 'admin' && $receiver->role !== 'admin') {
                $this->notifyUser($message, $receiver, $messageData);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send email notifications', [
                'message_id' => $message->id,
                'error' => $e->getMessage()
            ]);
            // لا نرمي الخطأ عشان ما نأثرش على حفظ الرسالة
        }
    }
    /**
     * إرسال إشعار لجميع الأدمنز
     */
    private function notifyAdmins($message, $sender, $messageData)
    {
        try {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isEmpty()) {
                \Log::warning('No admins found to notify');
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
                ]), function ($mail) use ($admin, $sender, $timestamp, $counter) {
                    $mail->to($admin->email)
                        ->subject('💬 رسالة جديدة رقم ' . ' #' . $timestamp . '-' . $counter);
                });
                $counter++;
            }


            \Log::info('Admin email notifications sent', [
                'message_id' => $message->id,
                'admin_count' => $admins->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to notify admins', [
                'message_id' => $message->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * إرسال إشعار للمستخدم
     */
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

            \Log::info('User email notification sent', [
                'message_id' => $message->id,
                'user_id' => $receiver->id,
                'user_email' => $receiver->email
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to notify user', [
                'message_id' => $message->id,
                'user_id' => $receiver->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
