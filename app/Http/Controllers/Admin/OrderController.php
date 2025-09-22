<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\Trip;
use App\Models\User;

class OrderController extends Controller
{
    public function messages($user_id, $product_id = null)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = OrderMessage::query()
            ->where(function ($query) use ($user_id) {
                $query->where('user_id', $user_id)
                    ->orWhere('user_id', Auth::id());
            })
            ->with(['user', 'product'])
            ->orderBy('created_at', 'asc');

        if ($product_id) {
            $query->where('product_id', $product_id);
        }

        $messages = $query->get();
        $user = User::findOrFail($user_id);
        $product = Product::findOrFail($product_id); // جلب بيانات المنتج

        return view('admin.omdaHome.orders.messages', compact('messages', 'user', 'product_id'));
    }  
    
    
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:في المراجعة,بإنتظار الدفع,بإنتظار مستندات,تحت الإجراء,ملغي,مكرر,منتهي,تم الاستلام في الصين,تم الاستلام بالامارات,تم الاستلام من قبل العميل',
            'order_type' => 'required|in:App\\Models\\TripRequest,App\\Models\\Product',
        ]);

        $order = $request->order_type == 'App\\Models\\TripRequest'
            ? TripRequest::findOrFail($id)
            : Product::findOrFail($id);

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

        return view('admin.omdaHome.orders.index', compact('trip_requests', 'products', 'bookings'));
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

        // Fetch the order (either a trip or a product)
        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Fetch invoices related to this order
        $invoices = Invoice::where('order_id', $id)
            ->where('order_type', $orderType)
            ->get();

        return view('admin.omdaHome.orders.invoice', compact('order', 'orderType', 'invoices', 'status', 'search'));
    }

    public function createInvoice(Request $request, string $id)
    {
        // Fetch the order
        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Generate dynamic invoice_number
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
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:مدفوعة,غير مدفوعة,ملغية',
        ]);

        // Fetch the order
        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Store the invoice
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'order_id' => $id,
            'user_id' => Auth::user()->id,
            'order_type' => $orderType,
            'invoice_date' => $request->invoice_date,
            'title' => $request->title,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.invoice', $id)->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function showInvoice(Request $request, string $invoice_id)
    {
        // Fetch the invoice
        $invoice = Invoice::findOrFail($invoice_id);

        // Fetch the related order based on the polymorphic relationship
        $order = $invoice->order; // This uses the morphTo relationship

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب المرتبط بالفاتورة غير موجود');
        }

        return view('admin.omdaHome.orders.showInvoice', compact('invoice', 'order'));
    }

    public function note(Request $request, string $id)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        // Fetch the order
        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Fetch notes related to this order
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

    public function createNote(Request $request, string $id)
    {
        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Generate dynamic note_number
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
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $orderType = $trip ? TripRequest::class : Product::class;

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('notes', 'public');
        }

        // Store the note
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
        ]);

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

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

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

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Generate dynamic document_number
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
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $orderType = $trip ? TripRequest::class : Product::class;

        // Handle file upload
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
            'user_id' => Auth::id(),
        ]);

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

        // Handle file upload
        $filePath = $document->file_path;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('documents', 'public');
        }

        // Update the document
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

        // Delete associated file if exists
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

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        $shippingNotes = ShippingNote::with('user')->where('order_id', $id)->where('order_type', $orderType);

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

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Generate dynamic note_number
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
        ]);

        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $orderType = $trip ? TripRequest::class : Product::class;

        // Handle file upload
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
        ]);

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
        ]);

        // Handle file upload
        $filePath = $shippingNote->file_path;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('shipping_notes', 'public');
        }

        // Update the shipping note
        $shippingNote->update([
            'note_number' => $request->note_number,
            'note_date' => $request->note_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.orders.shippingNote', $shippingNote->order_id)->with('success', 'تم تعديل ملاحظة الشحن بنجاح');
    }

    public function destroyShippingNote(Request $request, string $shipping_note_id)
    {
        $shippingNote = ShippingNote::findOrFail($shipping_note_id);

        // Delete associated file if exists
        if ($shippingNote->file_path && Storage::disk('public')->exists($shippingNote->file_path)) {
            Storage::disk('public')->delete($shippingNote->file_path);
        }

        $order_id = $shippingNote->order_id;
        $shippingNote->delete();

        return redirect()->route('admin.orders.shippingNote', $order_id)->with('success', 'تم حذف ملاحظة الشحن بنجاح');
    }

    public function approval(Request $request, string $id)
    {
        $search = $request->input('search');

        $trip = TripRequest::find($id);
        $product = Product::find($id);

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        $approvals = Approval::where('order_id', $id)->where('order_type', $orderType);

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

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $order = $trip ?? $product;
        $orderType = $trip ? TripRequest::class : Product::class;

        // Generate dynamic approval_number
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

        if (!$trip && !$product) {
            return redirect()->route('admin.orders.index')->with('error', 'الطلب غير موجود');
        }

        $orderType = $trip ? TripRequest::class : Product::class;

        // Handle file upload
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
        ]);

        return redirect()->route('admin.orders.approval', $id)->with('success', 'تم إنشاء الموافقة بنجاح');
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

        // Handle file upload
        $filePath = $approval->file_path;
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('approvals', 'public');
        }

        // Update the approval
        $approval->update([
            'approval_number' => $request->approval_number,
            'approval_date' => $request->approval_date,
            'title' => $request->title,
            'details' => $request->details,
            'file_path' => $filePath,
            'status' => 'يحتاج الموافقة',
        ]);

        return redirect()->route('admin.orders.approval', $approval->order_id)->with('success', 'تم تعديل الموافقة بنجاح');
    }

    public function destroyApproval(Request $request, string $approval_id)
    {
        $approval = Approval::findOrFail($approval_id);

        // Delete associated file if exists
        if ($approval->file_path && Storage::disk('public')->exists($approval->file_path)) {
            Storage::disk('public')->delete($approval->file_path);
        }

        $order_id = $approval->order_id;
        $approval->delete();

        return redirect()->route('admin.orders.approval', $order_id)->with('success', 'تم حذف الموافقة بنجاح');
    }
    public function destroy(string $id)
    {
        //
    }
}
