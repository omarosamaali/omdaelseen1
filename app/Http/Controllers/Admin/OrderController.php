<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Places;
use Illuminate\Http\Request;
use App\Models\TripRequest;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Note;
use App\Models\Document;
use App\Models\ShippingNote;
use App\Models\Approval;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderMessage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\TravelChat;
use App\Models\TripRegistration;
use App\Models\UnpaidTripRequests;
use App\Models\Adds;

class OrderController extends Controller
{
    public function tripMessages($user_id, $order_id, $order_type)
    {
        $orderModel = match ($order_type) {
            'unpaid' => UnpaidTripRequests::class,
            'registration' => TripRegistration::class,
            'trip_request' => TripRequest::class,
            default => abort(404, 'نوع الطلب غير صحيح')
        };

        $messages = TravelChat::query()
            ->where('order_id', $order_id)
            ->where('order_type', $orderModel)
            ->with(['user'])
            ->orderBy('created_at', 'asc')
            ->get();

        \Log::info('Messages fetched:', [
            'count' => $messages->count(),
            'order_id' => $order_id,
            'order_type' => $orderModel,
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'user_id' => $msg->user_id,
                    'user_role' => $msg->user?->role ?? 'NO USER',
                ];
            })
        ]);
        $user = User::findOrFail($user_id);
        $order = $orderModel::findOrFail($order_id);
        return view('admin.omdaHome.orders.trip-messages', compact('messages', 'user', 'order_id', 'order', 'order_type'));
    }

    public function sendTripMessage(Request $request)
    {
        \Log::info('sendTripMessage called', $request->all());
        $request->validate([
            'order_id' => 'required|integer',
            'order_type' => 'required|string|in:unpaid,registration,trip_request',
            'message' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ]);
        $orderModel = match ($request->order_type) {
            'unpaid' => UnpaidTripRequests::class,
            'registration' => TripRegistration::class,
            'trip_request' => TripRequest::class,
        };
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
    
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:في المراجعة,بإنتظار الدفع,بإنتظار مستندات,تحت الإجراء,ملغي,مكرر,منتهي,تم الاستلام في الصين,تم الاستلام بالامارات,تم الاستلام من قبل العميل',
            'order_type' => 'required|in:App\\Models\\TripRequest,App\\Models\\Product,App\\Models\\UnpaidTripRequests,App\\Models\\TripRegistration,App\\Models\\Payment',
        ]);

        switch ($request->order_type) {
            case 'App\\Models\\TripRequest':
                $order = TripRequest::findOrFail($id);
                break;
            case 'App\\Models\\Product':
                $order = Product::findOrFail($id);
                break;
            case 'App\\Models\\UnpaidTripRequests':
                $order = UnpaidTripRequests::findOrFail($id);
                break;
            case 'App\\Models\\TripRegistration':
                $order = TripRegistration::findOrFail($id);
                break;
            case 'App\\Models\\Payment':
                $order = Payment::findOrFail($id);
                break;
            default:
                return response()->json(['error' => 'نوع الطلب غير صحيح'], 400);
        }

        $order->update(['status' => $request->status]);

        return response()->json(['success' => 'تم تحديث الحالة بنجاح']);
    }

    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $trip_requests = TripRequest::with(['user' => function ($query) {
            $query->withCount([
                'followers',
                'tripRequests',
                'places'
            ]);
        }]);

        $products = Product::with(['user' => function ($query) {
            $query->withCount([
                'followers',
                'tripRequests',
                'places'
            ]);
        }]);

        $bookings = Booking::with(['user' => function ($query) {
            $query->withCount([
                'followers',
                'tripRequests',
                'places'
            ]);
        }]);

        if ($status) {
            $products->where('status', $status);
            $trip_requests->where('status', $status);
            $bookings->where('status', $status);
        };

        if ($search) {
            $search = trim($search);
            if (str_contains($search, 'رحلة')) {
                $products->whereRaw('1 = 0');
            } elseif (str_contains($search, 'منتج')) {
                $trip_requests->whereRaw('1 = 0');
            } elseif (str_contains($search, 'رحلة')) {
                $bookings->whereRaw('1 = 0');
            } else {
                $trip_requests->whereRelation('user', 'name', 'LIKE', "%{$search}%");
                $products->whereRelation('user', 'name', 'LIKE', "%{$search}%");
                $bookings->whereRelation('user', 'name', 'LIKE', "%{$search}%");
            }
        }

        $products = $products->get();
        $bookings = $bookings->get();
        $trip_requests = $trip_requests->get();

        $unpaidTripRequests = UnpaidTripRequests::with(['trip', 'user'])->get();
        $tripRegisters = TripRegistration::all();
        $adds = Payment::all();

        return view('admin.omdaHome.orders.index', compact('adds', 'tripRegisters', 'unpaidTripRequests', 'trip_requests', 'products', 'bookings'));
    }

    public function showProduct(string $id)
    {
        $trip_request = Product::find($id)->with(relations: 'orderProducts')->first();
        $places_count = Places::where('user_id', $trip_request->user_id)->count();
        return view('admin.omdaHome.orders.show-product', compact('trip_request', 'places_count'));
    }

    public function bookingShow(string $id)
    {
        $trip_request = Booking::find($id);
        $places_count = Places::where('user_id', $trip_request->user_id)->count();
        return view('admin.omdaHome.orders.booking-show', compact('trip_request', 'places_count'));
    }

    public function tripShowClient(string $id)
    {
        $trip_request = UnpaidTripRequests::find($id);
        return view('admin.omdaHome.orders.trip-show-client', compact('trip_request'));
    }

    public function tripShowRegister(string $id)
    {
        $trip_request = TripRegistration::find($id);
        if (!$trip_request) {
            $trip_request = Payment::find($id);
        }
        return view('admin.omdaHome.orders.trip-show-register', compact('trip_request'));
    }

    public function show(string $id)
    {
        $trip_request = TripRequest::find($id);
        $places_count = Places::where('user_id', $trip_request->user_id)->count();
        return view('admin.omdaHome.orders.show', compact('trip_request', 'places_count'));
    }


    public function edit(string $id)
    {
        $trip_request = TripRequest::find($id);
        return view('admin.omdaHome.orders.edit', compact('trip_request'));
    }

    public function invoice(Request $request, string $id)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if ($trip) {
            $order = $trip;
            $orderType = TripRequest::class;
        } elseif ($product) {
            $order = $product;
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $order = $unpaidTripRequest;
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $order = $tripRegistration;
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {  
            $order = $tripPayment;
            $orderType = Payment::class;
        } else {
            return redirect()->route('admin.orders.index')
                ->with('error', 'الطلب غير موجود');
        }

        $invoices = Invoice::where('order_id', $id)
            ->where('order_type', $orderType)
            ->get();

        return view('admin.omdaHome.orders.invoice', compact('order', 'orderType', 'invoices', 'status', 'search'));
    }

    public function createInvoice(Request $request, string $id)
    {
        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);  
        $tripPayment = Payment::find($id);

        if ($trip) {
            $order = $trip;
            $orderType = TripRequest::class;
        } elseif ($product) {
            $order = $product;
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $order = $unpaidTripRequest;
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $order = $tripRegistration;
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {  
            $order = $tripPayment;
            $orderType = Payment::class;
        } else {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $latestInvoice = Invoice::latest('id')->first();
        $nextId = $latestInvoice ? $latestInvoice->id + 1 : 1;
        $invoiceNumber = 'INV' . str_pad($nextId, 9, '0', STR_PAD_LEFT);

        return view('admin.omdaHome.orders.createInvoice', compact('order', 'orderType', 'invoiceNumber'));
    }

    public function storeInvoice(Request $request, string $id)
    {
        $request->validate([
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'title' => 'required|string',
            'trip_id' => 'nullable|exists:trips,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:مدفوعة,غير مدفوعة,ملغية',
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);  
        $tripPayment = Payment::find($id);

        if ($trip) {
            $order = $trip;
            $orderType = TripRequest::class;
        } elseif ($product) {
            $order = $product;
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $order = $unpaidTripRequest;
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $order = $tripRegistration;
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) { // 👈 جدي
            $order = $tripPayment;
            $orderType = Payment::class;
        } else {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $tripId = $request->trip_id;

        // 👇 عدلت الشرط عشان يشمل TripRegistration
        if (
            $orderType == TripRequest::class ||
            $orderType == UnpaidTripRequests::class ||
            $orderType == TripRegistration::class ||
            $orderType == Payment::class
        ) {
            if (!$tripId && isset($order->trip->id)) {
                $tripId = $order->trip->id;
            }
        }

        $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number,
            'order_id' => $id,
            'user_id' => Auth::id(),
            'order_type' => $orderType,
            'invoice_date' => $request->invoice_date,
            'trip_id' => $tripId, // 👈 استخدمت المتغير
            'title' => $request->title,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        if ($order->user && $order->user->email) {
            Mail::raw("تم إضافة فاتورة جديدة برقم: {$invoice->invoice_number} للطلب الخاص بك.", function ($mail) use ($order, $invoice) {
                $mail->to($order->user->email)->subject('تم إنشاء الفاتورة');
            });
        }

        return redirect()->route('admin.orders.invoice', $id)->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function showInvoice(Request $request, string $invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $order = $invoice->order;
        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالفاتورة غير موجود');
        }
        $status = $request->input('status');
        $search = $request->input('search');
        return view('admin.omdaHome.orders.showInvoice', compact('invoice', 'order', 'status', 'search'));
    }

    public function note(Request $request, string $id)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration && !$tripPayment) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product ?? $unpaidTripRequest ?? $tripRegistration ?? $tripPayment;

        $orderType = $trip
            ? TripRequest::class
            : ($product
                ? Product::class
                : ($unpaidTripRequest
                    ? UnpaidTripRequests::class
                    : ($tripRegistration
                        ? TripRegistration::class
                        : Payment::class)));

        $notes = Note::where('order_id', $id)
            ->where('order_type', $orderType);

        if ($status) {
            $notes->where('status', $status);
        }

        if ($search) {
            $notes->where(function ($query) use ($search) {
                $query->where('note_number', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%");
            });
        }

        $notes = $notes->get();

        return view('admin.omdaHome.orders.note', compact('order', 'orderType', 'notes', 'status', 'search'));
    }

    public function createNote(Request $request, string $id){
        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration && !$tripPayment) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product ?? $unpaidTripRequest ?? $tripRegistration ?? $tripPayment;

        $orderType = $trip
            ? TripRequest::class
            : ($product
                ? Product::class
                : ($unpaidTripRequest
                    ? UnpaidTripRequests::class
                    : ($tripRegistration
                        ? TripRegistration::class
                        : Payment::class)));

        $latestNote = Note::latest('id')->first();
        $nextId = $latestNote ? $latestNote->id + 1 : 1;
        $noteNumber = 'NOTE' . str_pad($nextId, 9, '0', STR_PAD_LEFT);

        return view('admin.omdaHome.orders.createNote', compact('order', 'orderType', 'noteNumber'));
    }

    public function storeNote(Request $request, string $id)
    {
        $request->validate([
            'note_number' => 'required|string|unique:notes,note_number',
            'note_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status' => 'required|in:عامة,خاصة,ملغية',
            'trip_id' => 'nullable|exists:trips,id',
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration && !$tripPayment) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $orderType = $trip
            ? TripRequest::class
            : ($product
                ? Product::class
                : ($unpaidTripRequest
                    ? UnpaidTripRequests::class
                    : ($tripRegistration
                        ? TripRegistration::class
                        : Payment::class)));

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('notes', 'public');
        }

        Note::create([
            'note_number' => $request->note_number,
            'order_id' => $id,
            'order_type' => $orderType,
            'note_date' => $request->note_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'user_id' => Auth::user()->id,
            'status' => $request->status,
            'trip_id' => $request->trip_id ? $request->trip_id : null,
        ]);

        $userId = $trip
            ? $trip->user_id
            : ($product
                ? $product->user_id
                : ($unpaidTripRequest
                    ? $unpaidTripRequest->user_id
                    : ($tripRegistration
                        ? $tripRegistration->user_id
                        : $tripPayment->user_id)));

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('admin.orders.index')->with('error', 'المستخدم غير موجود');
        }

        Mail::raw('قم بالرجوع للتطبيق لمراجعة تفاصيل الملاحظة', function ($message) use ($user) {
            $message->to($user->email)->subject('تمت إضافة ملاحظة بنجاح من قبل فريق عمدة الصين');
        });

        return redirect()->route('admin.orders.note', $id)->with('success', 'تم إنشاء الملاحظة بنجاح');
    }

    public function showNote(Request $request, string $note_id)
    {
        $note = Note::findOrFail($note_id);
        $order = $note->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالملاحظة غير موجود');
        }

        return view('admin.omdaHome.orders.showNote', compact('note', 'order'));
    }

    public function document(Request $request, string $id)
    {
        $search = $request->input('search');

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if ($trip) {
            $order = $trip;
            $orderType = TripRequest::class;
        } elseif ($product) {
            $order = $product;
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $order = $unpaidTripRequest;
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $order = $tripRegistration;
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {
            $order = $tripPayment;
            $orderType = Payment::class;
        } else {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $documents = Document::with('user')->where('order_id', $id)->where('order_type', $orderType);

        if ($search) {
            $documents->where(function ($query) use ($search) {
                $query->where('document_number', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%");
            });
        }

        $documents = $documents->get();

        return view('admin.omdaHome.orders.document', compact('order', 'orderType', 'documents', 'search'));
    }

    public function createDocument(Request $request, string $id)
    {
        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if ($trip) {
            $order = $trip;
            $orderType = TripRequest::class;
        } elseif ($product) {
            $order = $product;
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $order = $unpaidTripRequest;
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $order = $tripRegistration;
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {
            $order = $tripPayment;
            $orderType = Payment::class;
        } else {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $latestDocument = Document::latest('id')->first();
        $nextId = $latestDocument ? $latestDocument->id + 1 : 1;
        $documentNumber = 'DOC' . str_pad($nextId, 9, '0', STR_PAD_LEFT);

        return view('admin.omdaHome.orders.createDocument', compact('order', 'orderType', 'documentNumber'));
    }

    public function storeDocument(Request $request, string $id)
    {
        $request->validate([
            'document_number' => 'required|string|unique:documents,document_number',
            'document_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'trip_id' => 'nullable|exists:trips,id',
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if ($trip) {
            $order = $trip;
            $orderType = TripRequest::class;
        } elseif ($product) {
            $order = $product;
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $order = $unpaidTripRequest;
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $order = $tripRegistration;
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {
            $order = $tripPayment;
            $orderType = Payment::class;
        } else {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $userId = $trip
            ? $trip->user_id
            : ($product
                ? $product->user_id
                : ($unpaidTripRequest
                    ? $unpaidTripRequest->user_id
                    : ($tripRegistration
                        ? $tripRegistration->user_id
                        : $tripPayment->user_id)));

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('admin.orders.index')->with('error', 'المستخدم غير موجود');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        Document::create([
            'document_number' => $request->document_number,
            'order_id' => $id,
            'order_type' => $orderType,
            'document_date' => $request->document_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'trip_id' => $request->trip_id ? $request->trip_id : null,
            'user_id' => Auth::id(),
        ]);

        Mail::raw('قم بالرجوع للتطبيق لمراجعة تفاصيل المستند', function ($message) use ($user) {
            $message->to($user->email)->subject('تمت إضافة مستند جديد بنجاح من قبل فريق عمدة الصين');
        });

        return redirect()->route('admin.orders.document', $id)->with('success', 'تم إنشاء المستند بنجاح');
    }

    public function showDocument(Request $request, string $document_id)
    {
        $document = Document::with('user')->findOrFail($document_id);
        $order = $document->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالمستند غير موجود');
        }

        return view('admin.omdaHome.orders.showDocument', compact('document', 'order'));
    }

    public function editDocument(Request $request, string $document_id)
    {
        $document = Document::findOrFail($document_id);
        $order = $document->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالمستند غير موجود');
        }

        $orderType = $document->order_type;

        return view('admin.omdaHome.orders.editDocument', compact('document', 'order', 'orderType'));
    }

    public function updateDocument(Request $request, string $document_id)
    {
        $document = Document::findOrFail($document_id);

        $request->validate([
            'document_number' => 'required|string|unique:documents,document_number,' . $document->id,
            'document_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $filePath = $document->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('documents', 'public');
        }

        $document->update([
            'document_number' => $request->document_number,
            'document_date' => $request->document_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.orders.document', $document->order_id)->with('success', 'تم تعديل المستند بنجاح');
    }

    public function destroyDocument(Request $request, string $document_id)
    {
        $document = Document::findOrFail($document_id);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $order_id = $document->order_id;
        $document->delete();

        return redirect()->route('admin.orders.document', $order_id)->with('success', 'تم حذف المستند بنجاح');
    }

    public function editNote(Request $request, string $note_id)
    {
        $note = Note::findOrFail($note_id);
        $order = $note->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالملاحظة غير موجود');
        }

        $orderType = $note->order_type;

        return view('admin.omdaHome.orders.editNote', compact('note', 'order', 'orderType'));
    }

    public function updateNote(Request $request, string $note_id)
    {
        $note = Note::findOrFail($note_id);

        $request->validate([
            'note_number' => 'required|string|unique:notes,note_number,' . $note->id,
            'note_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status' => 'required|in:عامة,خاصة,ملغية',
        ]);

        // Handle file upload
        $filePath = $note->file_path;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('notes', 'public');
        }

        // Update the note
        $note->update([
            'note_number' => $request->note_number,
            'note_date' => $request->note_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.note', $note->order_id)->with('success', 'تم تعديل الملاحظة بنجاح');
    }

    public function destroyNote(Request $request, string $note_id)
    {
        $note = Note::findOrFail($note_id);

        // Delete associated file if exists
        if ($note->file_path && Storage::disk('public')->exists($note->file_path)) {
            Storage::disk('public')->delete($note->file_path);
        }

        $order_id = $note->order_id;
        $note->delete();

        return redirect()->route('admin.orders.note', $order_id)->with('success', 'تم حذف الملاحظة بنجاح');
    }

    public function shippingNote(Request $request, string $id)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration && !$tripPayment) { // 👈 عدلت
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        if ($trip) {
            $orderType = TripRequest::class;
        } elseif ($product) {
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {
            $orderType = Payment::class;
        }

        $order = $trip ?? $product ?? $unpaidTripRequest ?? $tripRegistration ?? $tripPayment; // 👈 عدلت

        $shippingNotes = ShippingNote::with('user')->where('order_id', $id)
            ->where('order_type', $orderType);

        if ($search) {
            $shippingNotes->where(function ($query) use ($search) {
                $query->where('note_number', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%");
            });
        }

        if ($status) {
            $shippingNotes->where('status', $status);
        }

        $shippingNotes = $shippingNotes->get();

        return view('admin.omdaHome.orders.shippingNote', compact('order', 'orderType', 'shippingNotes', 'search', 'status'));
    }

    public function createShippingNote(Request $request, string $id)
    {
        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration && !$tripPayment) { // 👈 عدلت
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product ?? $unpaidTripRequest ?? $tripRegistration ?? $tripPayment; // 👈 عدلت

        $orderType =
            ($trip ? TripRequest::class : null)
            ?? ($product ? Product::class : null)
            ?? ($unpaidTripRequest ? UnpaidTripRequests::class : null)
            ?? ($tripRegistration ? TripRegistration::class : null)
            ?? ($tripPayment ? Payment::class : null);

        $latestNote = ShippingNote::latest('id')->first();
        $nextId = $latestNote ? $latestNote->id + 1 : 1;
        $noteNumber = 'SHPNOTE' . str_pad($nextId, 9, '0', STR_PAD_LEFT);

        return view('admin.omdaHome.orders.createShippingNote', compact('order', 'orderType', 'noteNumber'));
    }

    public function storeShippingNote(Request $request, string $id)
    {
        $request->validate([
            'note_number' => 'required|string|unique:shipping_notes,note_number',
            'note_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status' => 'required|in:التجهيز للشحن,تم الشحن',
            'trip_id' => 'nullable|exists:trips,id',
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);
        $tripPayment = Payment::find($id);

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration && !$tripPayment) { // 👈 عدلت
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        if ($trip) {
            $orderType = TripRequest::class;
        } elseif ($product) {
            $orderType = Product::class;
        } elseif ($unpaidTripRequest) {
            $orderType = UnpaidTripRequests::class;
        } elseif ($tripRegistration) {  
            $orderType = TripRegistration::class;
        } elseif ($tripPayment) {
            $orderType = Payment::class;
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('shipping_notes', 'public');
        }

        ShippingNote::create([
            'note_number' => $request->note_number,
            'order_id' => $id,
            'order_type' => $orderType,
            'note_date' => $request->note_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'trip_id' => $request->trip_id ? $request->trip_id : null,
        ]);

        // 👇 عدلت عشان يشمل TripRegistration
        $userId = null;
        if ($trip) {
            $userId = $trip->user_id;
        } elseif ($product) {
            $userId = $product->user_id;
        } elseif ($unpaidTripRequest) {
            $userId = $unpaidTripRequest->user_id;
        } elseif ($tripRegistration) {
            $userId = $tripRegistration->user_id;
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('admin.orders.index')->with('error', 'المستخدم غير موجود');
        }

        Mail::raw('قم بالرجوع للتطبيق لمراجعة تفاصيل الشحن ', function ($message) use ($user) {
            $message->to($user->email)->subject('تمت إضافة تفاصيل شحن جديدة بنجاح من قبل فريق عمدة الصين');
        });

        return redirect()->route('admin.orders.shippingNote', $id)->with('success', 'تم إنشاء ملاحظة الشحن بنجاح');
    }

    public function showShippingNote(Request $request, string $shipping_note_id)
    {
        $shippingNote = ShippingNote::with('user')->findOrFail($shipping_note_id);
        $order = $shippingNote->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بملاحظة الشحن غير موجود');
        }

        return view('admin.omdaHome.orders.showShippingNote', compact('shippingNote', 'order'));
    }

    public function editShippingNote(Request $request, string $shipping_note_id)
    {
        $shippingNote = ShippingNote::findOrFail($shipping_note_id);
        $order = $shippingNote->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بملاحظة الشحن غير موجود');
        }

        $orderType = $shippingNote->order_type;

        return view('admin.omdaHome.orders.editShippingNote', compact('shippingNote', 'order', 'orderType'));
    }

    public function updateShippingNote(Request $request, string $shipping_note_id)
    {
        $shippingNote = ShippingNote::findOrFail($shipping_note_id);

        $request->validate([
            'note_number' => 'required|string|unique:shipping_notes,note_number,' . $shippingNote->id,
            'note_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status' => 'required|in:التجهيز للشحن,تم الشحن',
            'trip_id' => 'nullable|exists:trips,id',
        ]);

        $filePath = $shippingNote->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('shipping_notes', 'public');
        }

        $shippingNote->update([
            'note_number' => $request->note_number,
            'note_date' => $request->note_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'trip_id' => $request->trip_id ? $request->trip_id : null,
        ]);

        return redirect()->route('admin.orders.shippingNote', $shippingNote->order_id)->with('success', 'تم تعديل ملاحظة الشحن بنجاح');
    }

    public function destroyShippingNote(Request $request, string $shipping_note_id)
    {
        $shippingNote = ShippingNote::findOrFail($shipping_note_id);

        if ($shippingNote->file_path && Storage::disk('public')->exists($shippingNote->file_path)) {
            Storage::disk('public')->delete($shippingNote->file_path);
        }

        $order_id = $shippingNote->order_id;
        $shippingNote->delete();

        return redirect()->route('admin.orders.shippingNote', $order_id)->with('success', 'تم حذف ملاحظة الشحن بنجاح');
    }

    public function editApproval(Request $request, string $approval_id)
    {
        $approval = Approval::findOrFail($approval_id);
        $order = $approval->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالموافقة غير موجود');
        }

        $orderType = $approval->order_type;

        return view('admin.omdaHome.orders.editApproval', compact('approval', 'order', 'orderType'));
    }

    public function showApproval(Request $request, string $approval_id)
    {
        $approval = Approval::findOrFail($approval_id);
        $order = $approval->order;

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالموافقة غير موجود');
        }

        return view('admin.omdaHome.orders.showApproval', compact('approval', 'order'));
    }

    public function updateApproval(Request $request, string $approval_id)
    {
        $approval = Approval::findOrFail($approval_id);

        $request->validate([
            'approval_number' => 'required|string|unique:approvals,approval_number,' . $approval->id,
            'approval_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $filePath = $approval->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('approvals', 'public');
        }

        $approval->update([
            'approval_number' => $request->approval_number,
            'approval_date' => $request->approval_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => 'يحتاج الموافقة',
        ]);

        return redirect()->route('admin.orders.approval', $approval->order_id)
            ->with('success', 'تم تعديل الموافقة بنجاح');
    }

    public function approval(Request $request, string $id)
    {
        $search = $request->input('search');

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);  

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration) { // 👈 عدلت
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product ?? $unpaidTripRequest ?? $tripRegistration; // 👈 عدلت

        $orderType = $trip
            ? TripRequest::class
            : ($product
                ? Product::class
                : ($unpaidTripRequest
                    ? UnpaidTripRequests::class
                    : TripRegistration::class)); // 👈 عدلت

        $approvals = Approval::where('order_id', $id)
            ->where('order_type', $orderType);

        if ($search) {
            $approvals->where(function ($query) use ($search) {
                $query->where('approval_number', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%");
            });
        }

        $approvals = $approvals->get();

        return view('admin.omdaHome.orders.approval', compact('order', 'orderType', 'approvals', 'search'));
    }

    public function createApproval(Request $request, string $id)
    {
        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);  

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration) { // 👈 عدلت
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product ?? $unpaidTripRequest ?? $tripRegistration; // 👈 عدلت

        $orderType = $trip
            ? TripRequest::class
            : ($product
                ? Product::class
                : ($unpaidTripRequest
                    ? UnpaidTripRequests::class
                    : TripRegistration::class)); // 👈 عدلت

        $latestApproval = Approval::latest('id')->first();
        $nextId = $latestApproval ? $latestApproval->id + 1 : 1;
        $approvalNumber = 'APPR' . str_pad($nextId, 9, '0', STR_PAD_LEFT);

        return view('admin.omdaHome.orders.createApproval', compact('order', 'orderType', 'approvalNumber'));
    }

    public function storeApproval(Request $request, string $id)
    {
        $request->validate([
            'approval_number' => 'required|string|unique:approvals,approval_number',
            'approval_date' => 'required|date',
            'title' => 'required|string',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',

        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);
        $unpaidTripRequest = UnpaidTripRequests::find($id);
        $tripRegistration = TripRegistration::find($id);  

        if (!$trip && !$product && !$unpaidTripRequest && !$tripRegistration) { // 👈 عدلت
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $orderType = $trip
            ? TripRequest::class
            : ($product
                ? Product::class
                : ($unpaidTripRequest
                    ? UnpaidTripRequests::class
                    : TripRegistration::class)); // 👈 عدلت

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('approvals', 'public');
        }

        Approval::create([
            'approval_number' => $request->approval_number,
            'order_id' => $id,
            'order_type' => $orderType,
            'approval_date' => $request->approval_date,
            'title' => $request->title,
            'user_id' => Auth::id(),
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => 'يحتاج الموافقة',
            'trip_id' => $request->trip_id ? $request->trip_id : null,
        ]);

        // 👇 عدلت عشان يشمل TripRegistration
        $userId = null;
        if ($trip) {
            $userId = $trip->user_id;
        } elseif ($product) {
            $userId = $product->user_id;
        } elseif ($unpaidTripRequest) {
            $userId = $unpaidTripRequest->trip?->user_id;
        } elseif ($tripRegistration) {
            $userId = $tripRegistration->user_id;
        }

        if (!$userId) {
            return redirect()->route('admin.orders.index')->with('error', 'تعذر تحديد المستخدم المرتبط بالطلب');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('admin.orders.index')->with('error', 'المستخدم غير موجود');
        }

        Mail::raw('قم بالرجوع للتطبيق لمراجعة تفاصيل الموافقة', function ($message) use ($user) {
            $message->to($user->email)->subject('تمت إضافة موافقة جديدة من قبل فريق عمدة الصين');
        });

        return redirect()->route('admin.orders.approval', $id)->with('success', 'تم إنشاء الموافقة بنجاح');
    }

    public function destroyApproval(Request $request, string $approval_id)
    {
        $approval = Approval::findOrFail($approval_id);

        if ($approval->file_path && Storage::disk('public')->exists($approval->file_path)) {
            Storage::disk('public')->delete($approval->file_path);
        }

        $order_id = $approval->order_id;
        $order_type = $approval->order_type;

        $approval->delete();

        // 👇 عدلت عشان يشمل TripRegistration
        if ($order_type === \App\Models\TripRequest::class) {
            return redirect()->route('admin.orders.approval', $order_id)
                ->with('success', 'تم حذف الموافقة بنجاح');
        } elseif ($order_type === \App\Models\Product::class) {
            return redirect()->route('admin.orders.approval', $order_id)
                ->with('success', 'تم حذف الموافقة بنجاح');
        } elseif ($order_type === \App\Models\UnpaidTripRequests::class) {
            return redirect()->route('admin.orders.approval', $order_id)
                ->with('success', 'تم حذف الموافقة بنجاح');
        } elseif ($order_type === \App\Models\TripRegistration::class) {  
            return redirect()->route('admin.orders.approval', $order_id)
                ->with('success', 'تم حذف الموافقة بنجاح');
        }

        return redirect()->route('admin.orders.index')->with('success', 'تم حذف الموافقة بنجاح');
    }
}
