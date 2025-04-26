<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // إضافة استدعاء مكتبة Mail
use App\Mail\ContactNotification;

class ContactMessageController extends Controller
{
    protected $layout;
    
    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }
    
    /**
     * Show the contact form for users.
     */
    public function show()
    {
        return view('users.contact.contact');
    }
    
    /**
     * Handle contact form submission.
     */

public function submit(Request $request)
{
    // Log that the method is being called
    \Log::info('Contact form submission started', $request->all());

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'message' => 'required|string',
        'accept_terms' => 'accepted',
    ]);

    $contactMessage = ContactMessage::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'message' => $validated['message'],
        'accept_terms' => $request->has('accept_terms'),
        'receipt_date' => now(),
        'status' => 'جديد',
    ]);

    // Log that the message was saved
    \Log::info('Contact message saved', $contactMessage->toArray());

    // Send email using Mailable with error handling
    try {
        Mail::to('chinaomda@gmail.com')->send(new ContactNotification($contactMessage));
        \Log::info('Email sent successfully to chinaomda@gmail.com');
    } catch (\Exception $e) {
        \Log::error('Failed to send contact notification email: ' . $e->getMessage());
        return redirect()->route('contact.show')->with('error', 'تم حفظ الرسالة، لكن فشل إرسال الإشعار بالبريد الإلكتروني. حاول مرة أخرى لاحقًا.');
    }

    return redirect()->route('contact.show')->with('success', 'تم إرسال رسالتك بنجاح!');
}
    /**
     * Display a listing of the resource (for admin).
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('receipt_date', 'desc')->paginate(10);
        return view('admin.omdaHome.contact-messages.index', compact('messages'))->with('layout', $this->layout);
    }
    
    /**
     * Display the specified resource (for admin).
     */
    public function showAdmin(string $id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.omdaHome.contact-messages.show', compact('message'))->with('layout', $this->layout);
    }
    
    /**
     * Remove the specified resource from storage (for admin).
     */
    public function destroy(string $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'تم حذف الرسالة بنجاح');
    }
    
    /**
     * Update the status of the specified resource (for admin).
     */
    public function updateStatus(Request $request, string $id)
    {
        $message = ContactMessage::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:جديد,تم الرد,مغلق',
        ]);
        
        $message->update([
            'status' => $request->status,
        ]);
        
        return redirect()->route('admin.contact-messages.show', $message->id)->with('success', 'تم تحديث حالة الرسالة بنجاح');
    }
}