<?php

use App\Models\Adds;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\ChinaDiscoverController;
use App\Models\Places;
use App\Models\Favorites;
use App\Models\Message;
use App\Models\Followers;
use App\Models\Report;
use App\Http\Controllers\ChatOrderController;
use App\Models\TripActivity;
use App\Models\About;
use App\Models\ReviewReport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\FavForPlacesController;
use App\Http\Controllers\Mobile\NotificationController;
use App\Models\Rating;
use App\Models\Regions;
use App\Models\Banner;
use App\Models\Privacy;
use App\Models\Terms;
use App\Models\Event;
use App\Models\Work;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FollowersUserController;
use App\Http\Controllers\TripRequestController;
use App\Http\Controllers\ProductController;
use App\Models\HelpWord;
use App\Models\Trip;
use App\Models\Explorers;
use App\Models\Product;
use App\Models\TripRequest;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Http\Controllers\ChatController;
use App\Models\Document;
use App\Models\Approval;
use App\Models\Note;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TripRegistrationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\PaymentController;
use App\Models\TripRegistration;
use App\Models\UnpaidTripRequests;

Route::post('/mobile/payment/start', [PaymentController::class, 'startPayment'])
    ->name('mobile.payment.start')
    ->middleware('auth');

// ✅ اعمل support لـ GET و POST معاً
Route::match(['get', 'post'], '/payment/callback', [PaymentController::class, 'handleCallback'])
    ->name('payment.callback');
Route::get('/mobile/trip-chat/{user_id}/{order_id}/{order_type}', [OrderController::class, 'tripMessages'])
    ->name('mobile.profile.actions.trip-chat');

Route::post('/mobile/trip-chat/send', [OrderController::class, 'sendTripMessage'])
    ->name('mobile.trip-chat.send');

Route::post('mobile/invoice/{invoiceId}/pay', [InvoiceController::class, 'initiatePayment'])
    ->name('mobile.invoice.pay');

Route::get('mobile/invoice/payment/success', [InvoiceController::class, 'paymentSuccess'])
    ->name('mobile.invoice.payment.success');
Route::get('mobile/invoice/payment/cancel', [InvoiceController::class, 'paymentCancel'])
    ->name('mobile.invoice.payment.cancel');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/notifications', function () {
        return view('admin.notifications');
    })->name('admin.notifications');
});

Route::post('/save-fcm-token', function (Request $request) {
    try {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $user = auth()->user();
        $updated = $user->update(['fcm_token' => $request->token]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Token saved successfully'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to update token'], 500);
    } catch (\Exception $e) {
        \Log::error('FCM Token Save Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error'], 500);
    }
});


Route::get('/emails/success-preview', function () {
    $booking = \App\Models\Booking::latest()->first();
    $trip = $booking->trip;
    $user = $booking->user;
    return view('emails.success', compact('booking', 'trip', 'user'));
});

Route::get('/trip/{id}/payment', [TripController::class, 'initiatePayment'])->name('trip.payment');

Route::get('/payment/success', function (Request $request) {
    return view('payment.success', [
        'trip_id' => $request->trip_id,
        'payment_intent_id' => $request->payment_intent_id
    ]);
})->name('payment.success');

Route::get('/payment/cancel', function (Request $request) {
    return view('payment.cancel', [
        'trip_id' => $request->trip_id
    ]);
})->name('payment.cancel');

// صفحة التسجيل للرحلة
Route::get('mobile/trip-register/{trip_id}', [TripRegistrationController::class, 'showRegistrationForm'])
    ->name('mobile.trip.register');

Route::match(['get', 'post'], '/trip/{id}/payment', [TripController::class, 'initiatePayment'])
    ->name('trip.payment');

// معالجة التسجيل والتوجه للدفع
Route::post('mobile/trip-register', [TripRegistrationController::class, 'quickRegisterAndPay'])
    ->name('mobile.trip.register.submit');
Route::get('payment/success', function (Request $request) {
    // معالجة الدفع الناجح
    return redirect()->route('home')->with('success', 'تم الدفع بنجاح!');
})->name('payment.success');

Route::get('payment/cancel', function (Request $request) {
    // معالجة الإلغاء
    return redirect()->route('home')->with('error', 'تم إلغاء الدفع');
})->name('payment.cancel');

Route::get('mobile/step2/{trip_id}', function ($trip_id) {
    $trip = App\Models\Trip::findOrFail($trip_id);
    return view('mobile.auth.step2', compact('trip'));
})->name('mobile.auth.step2');

Route::post('/mobile/auth/register-trip', [RegisteredUserController::class, 'registerForTrip'])
    ->name('mobile.auth.register');


Route::get('/debug-trip/{id}', [TripController::class, 'debugTrip'])->name('debug.trip');
// Route::post('/trip/{id}/payment', [TripController::class, 'initiatePayment'])->name('trip.payment');
Route::get('/payment/success', [TripController::class, 'paymentSuccess'])->name('trip.payment.success');
Route::get('/payment/cancel', [TripController::class, 'paymentCancel'])->name('trip.payment.cancel');


Route::get('mobile/done', function (Request $request) {
    $tripId = $request->query('trip');
    $trip = $tripId ? Trip::find($tripId) : null;
    $data = ['trip' => $trip];
    if (!$trip && !$request->session()->has('success')) {
        $data['warning'] = 'لا توجد رحلة مرتبطة بهذه الصفحة';
    }
    return view('mobile.auth.done', $data);
})->name('mobile.auth.done');

Route::get('/logout-and-register/{trip}', function ($tripId) {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return redirect()->route('mobile.trip.register', $tripId);
})->name('logout.and.register');


Route::get('/mobile/orders/trip-invoice/{id}', function ($id) {
    $product = Product::findOrFail($id)->load('invoices', 'notes');
    return view('mobile.profile.actions.trip-invoice', compact('product'));
})->name('mobile.profile.actions.trip-invoice');

Route::get('/mobile/orders/trip-invoice/{id}', function ($id) {
    // جلب TripRequest مش Product
    $trip = TripRequest::findOrFail($id)->load('invoices', 'notes');
    return view('mobile.profile.actions.trip-invoice', compact('trip'));
})->name('mobile.profile.actions.trip-invoice');

Route::get('mobile/china-discovers/{id?}', [ChinaDiscoverController::class, 'index'])->name('mobile.china-discovers.index');

Route::get('/mobile/orders/trip-user/{trip_requests}', function (App\Models\TripRequest $trip_requests) {
    $trip_requests->load('approvals', 'notes');
    return view('mobile.profile.trip-display', compact('trip_requests'));
})->name('mobile.orders.trip-display');
Route::get('/mobile/orders/trip-show-client/{id}', function ($id) {
    // ابحث في UnpaidTripRequests الأول
    $trip_requests = App\Models\UnpaidTripRequests::with('user')->find($id);

    // لو مش موجود، ابحث في TripRegistration
    if (!$trip_requests) {
        $trip_requests = App\Models\TripRegistration::with('user')->find($id);
    }

    // لو مش موجود في الاتنين، ارجع 404
    if (!$trip_requests) {
        abort(404, 'الطلب غير موجود');
    }

    return view('mobile.profile.trip-show-client', compact('trip_requests'));
})->name('mobile.orders.trip-show-client');

Route::delete('mobile/delete-note/{id}', function ($id) {
    try {
        $note = Note::findOrFail($id);
        $note->delete();
        return redirect()->route('mobile.profile.approve')->with('success', 'note deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete note');
    }
})->name('mobile.delete-note');

Route::delete('mobile/delete-approval/{id}', function ($id) {
    try {
        $approval = Approval::findOrFail($id);
        $approval->delete();
        return redirect()->route('mobile.profile.approve')->with('success', 'approval deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete approval');
    }
})->name('mobile.delete-approve');

Route::delete('mobile/delete-document/{id}', function ($id) {
    try {
        $document = Document::findOrFail($id);
        $document->delete();
        return redirect()->route('mobile.profile.doc')->with('success', 'document deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete document');
    }
})->name('mobile.delete-document');

Route::delete('mobile/delete-invoice/{id}', function ($id) {
    try {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('mobile.profile.invoices')->with('success', 'Invoice deleted successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete invoice');
    }
})->name('mobile.delete-invoice');

Route::get('/mobile/orders/orders-admin', function (Request $request) {
    $status = $request->get('status');
    $statuses = [
        'في المراجعة',
        'بإنتظار الدفع',
        'التجهيز للشحن',
        'تم الشحن',
        'تم الاستلام من قبل العميل',
        'بإنتظار مستندات',
        'تحت الإجراء',
        'تم الاستلام في الصين',
        'تم الاستلام بالامارات',
        'ملغي',
        'مكرر',
        'منتهي',
        'تحتاج لموافقة'
    ];
    $productStats = array_fill_keys($statuses, 0);

    // إحصائيات المنتجات
    $productStatsData = Product::groupBy('status')
        ->select('status', \DB::raw('count(*) as total'))
        ->pluck('total', 'status')
        ->toArray();

    // إحصائيات طلبات الرحلات
    $tripStatsData = TripRequest::groupBy('status')
        ->select('status', \DB::raw('count(*) as total'))
        ->pluck('total', 'status')
        ->toArray();

    // دمج الإحصائيات
    foreach ($statuses as $s) {
        $productStats[$s] = ($productStatsData[$s] ?? 0) + ($tripStatsData[$s] ?? 0);
    }

    $productsQuery = Product::with('approvals', 'notes');
    $tripRequestsQuery = TripRequest::query();
    $unPaidTripsQuery = UnpaidTripRequests::query();
    $trip_registers = TripRegistration::query();
    if ($status) {
        $productsQuery->where('status', $status);
        $tripRequestsQuery->where('status', $status);
        $unPaidTripsQuery->where('status', $status);
        $trip_registers->where('status', $status);
    }

    $products = $productsQuery->get();
    $trip_requests = $tripRequestsQuery->get();
    $unPaidTrips = $unPaidTripsQuery->get();
    $trip_registers = $trip_registers->get();

    return view(
        'mobile.profile.orders-admin',
        compact('products', 'trip_requests', 'productStats', 'status', 'unPaidTrips', 'trip_registers')
    );
})->name('mobile.admin-orders');

// في ملف routes/web.php
Route::get('/mobile/orders/orders-user', function () {
    $userId = Auth::user()->id;
    $tripsFinished = TripRequest::where('user_id', $userId)
        ->where('status', 'منتهية')
        ->count();
    $tripsUnfinished = TripRequest::where('user_id', $userId)
        ->where('status', '!=', 'منتهية')
        ->count();
    $productsFinished = Product::where('user_id', $userId)
        ->where('status', 'منتهية')
        ->count();
    $productsUnfinished = Product::where('user_id', $userId)
        ->where('status', '!=', 'منتهية')
        ->count();
    $unpaidTripRequests = UnpaidTripRequests::where('user_id', $userId)->get();
    $tripRegisters = TripRegistration::where('user_id', $userId)->get();
    $specialOrdersFinished = 0;
    $specialOrdersUnfinished = 0;
    $filter = request('filter', 'all');

    $productsQuery = Product::where('user_id', $userId)
        ->with('approvals')
        ->with('notes');

    $tripRequestsQuery = TripRequest::where('user_id', $userId);

    // تطبيق الفلتر
    switch ($filter) {
        case 'trips_finished':
            $tripRequestsQuery->where('status', 'منتهية');
            $productsQuery->whereRaw('1 = 0');
            break;

        case 'trips_unfinished':
            $tripRequestsQuery->where('status', '!=', 'منتهية');
            $productsQuery->whereRaw('1 = 0');
            break;

        case 'products_finished':
            $productsQuery->where('status', 'منتهية');
            $tripRequestsQuery->whereRaw('1 = 0');
            break;

        case 'products_unfinished':
            $productsQuery->where('status', '!=', 'منتهية');
            $tripRequestsQuery->whereRaw('1 = 0');
            break;

        case 'all':
        default:
            break;
    }

    $products = $productsQuery->get();
    $trip_requests = $tripRequestsQuery->get();

    return view('mobile.profile.orders-user', compact(
        'unpaidTripRequests',
        'products',
        'trip_requests',
        'tripsFinished',
        'tripsUnfinished',
        'productsFinished',
        'productsUnfinished',
        'specialOrdersFinished',
        'specialOrdersUnfinished',
        'tripRegisters',
        'filter'
    ));
})->name('mobile.orders');

Route::get('/mobile/orders/note/{productId}/show/{noteId}', function ($productId, $noteId) {
    $product = Product::findOrFail($productId);
    $note = Note::findOrFail($noteId);
    return view('mobile.profile.actions.show_note', compact('product', 'note'));
})->name('mobile.profile.actions.show_note');

Route::get('/mobile/orders/note/{id}', function ($id) {
    $product = Product::findOrFail($id)->load('notes');
    return view('mobile.profile.actions.note', compact('product'));
})->name('mobile.profile.actions.note');

Route::get('/mobile/orders/note/{tripId}/show-trip/{noteId}', function ($tripId, $noteId) {
    $trip = TripRequest::find($tripId);
    if(!$trip){
        $trip = UnpaidTripRequests::find($tripId);
    }
    if(!$trip) {
        $trip = TripRegistration::find($tripId);
    }
    $note = Note::findOrFail($noteId);
    return view('mobile.profile.actions.show_note-trip', compact('trip', 'note'));
})->name('mobile.profile.actions.show_note-trip');

Route::get('/mobile/orders/note/{tripId}/show-trip-client/{noteId}', function ($tripId, $noteId) {
    $trip = UnpaidTripRequests::find($tripId);
    if (!$trip) {
        $trip = TripRegistration::find($tripId);
    }
    $note = Note::findOrFail($noteId);
    return view('mobile.profile.actions.show_note-trip-client', compact('trip', 'note'));
})->name('mobile.profile.actions.show_note-trip-client');

Route::get('/mobile/orders/note-trip/{id}', function ($id) {
    $trip = TripRequest::with('notes')->find($id);
    if(!$trip){
        $trip = UnpaidTripRequests::with('notes')->find($id);
    }
    if(!$trip){
        $trip = TripRegistration::with('notes')->find($id);
    }
    return view('mobile.profile.actions.note-trip', compact('trip'));
})->name('mobile.profile.actions.note-trip');

Route::get('/mobile/orders/note-trip-client/{id}', function ($id) {
    $trip = UnpaidTripRequests::with('notes')->find($id);
    if (!$trip) {
        $trip = TripRegistration::with('notes')->find($id);
    }

    return view('mobile.profile.actions.note-trip-client', compact('trip'));
})->name('mobile.profile.actions.note-trip-client');

Route::get('/mobile/orders/approve/{productId}/show/{approveId}', function ($productId, $approveId) {
    $product = Product::findOrFail($productId);
    $approve = Approval::findOrFail($approveId);
    return view('mobile.profile.actions.show_approve', compact('product', 'approve'));
})->name('mobile.profile.actions.show_approve');

Route::get('/mobile/orders/approve/{tripId}/show-trip/{approveId}', function ($tripId, $approveId) {
    $trip = UnpaidTripRequests::with('approvals', 'notes')->find($tripId);
    if (!$trip) {
        $trip = TripRegistration::with('approvals', 'notes')->find($tripId);
    }
    if (!$trip) {
        $trip = TripRequest::with('approvals', 'notes')->find($tripId);
    }
    // $trip = TripRequest::findOrFail($tripId);
    $approve = Approval::findOrFail($approveId);
    return view('mobile.profile.actions.show_approve-trip', compact('trip', 'approve'));
})->name('mobile.profile.actions.show_approve-trip');

Route::get('/mobile/orders/approve/{tripId}/show-trip-client/{approveId}', function ($tripId, $approveId) {
    $trip = UnpaidTripRequests::find($tripId);
    if (!$trip) {
        TripRegistration::find($tripId);
    }
    $approve = Approval::findOrFail($approveId);
    return view('mobile.profile.actions.show_approve-trip-client', compact('trip', 'approve'));
})->name('mobile.profile.actions.show_approve-trip-client');

Route::get('/mobile/orders/approve/{id}', function ($id) {
    $product = Product::findOrFail($id)->load('approvals', 'notes');
    return view('mobile.profile.actions.approve', compact('product'));
})->name('mobile.profile.actions.approve');

Route::get('/mobile/orders/approve-trip/{id}', function ($id) {
    $trip = UnpaidTripRequests::with('approvals', 'notes')->find($id);
    if (!$trip) {
        $trip = TripRegistration::with('approvals', 'notes')->find($id);
    }
    if (!$trip) {
        $trip = TripRequest::with('approvals', 'notes')->find($id);
    }
    return view('mobile.profile.actions.approve-trip', compact('trip'));
})->name('mobile.profile.actions.approve-trip');

Route::get('/mobile/orders/approve-trip-client/{id}', function ($id) {
    $trip = UnpaidTripRequests::with('approvals', 'notes')->find($id);
    if (!$trip) {
        $trip = TripRegistration::with('approvals', 'notes')->find($id);
    }
    return view('mobile.profile.actions.approve-trip-client', compact('trip'));
})->name('mobile.profile.actions.approve-trip-client');


Route::get('/mobile/orders/invoice/{productId}/show/{invoiceId}', function ($productId, $invoiceId) {
    $product = Product::findOrFail($productId);
    $invoice = Invoice::findOrFail($invoiceId);
    return view('mobile.profile.actions.show_invoice', compact('product', 'invoice'));
})->name('mobile.profile.actions.show_invoice');

Route::get('/mobile/orders/invoice/{tripId}/show-trip/{invoiceId}', function ($tripId, $invoiceId) {
    $trip = UnpaidTripRequests::with('invoices')->find($tripId);
    if (!$trip) {
        $trip = TripRegistration::with('invoices')->find($tripId);
    }
    if (!$trip) {
        $trip = TripRequest::with('invoices')->find($tripId);
    }
    $invoice = Invoice::findOrFail($invoiceId);
    return view('mobile.profile.actions.show_invoice-trip', compact('trip', 'invoice'));
})->name('mobile.profile.actions.show_invoice-trip');

Route::get('/mobile/orders/invoice/{tripId}/show-trip-client/{invoiceId}', function ($tripId, $invoiceId) {
    $trip = UnpaidTripRequests::find($tripId);
    if (!$trip) {
        $trip = TripRegistration::find($tripId);
    }
    if (!$trip) {
        // abort(404, 'الطلب غير موجود');
        $trip = TripRequest::find($tripId);
    }
    $invoice = Invoice::findOrFail($invoiceId);

    return view('mobile.profile.actions.show_invoice-trip-client', compact('trip', 'invoice'));
})->name('mobile.profile.actions.show_invoice-trip-client');

Route::get('/mobile/orders/invoice/{id}', function ($id) {
    $product = Product::findOrFail($id)->load('invoices', 'notes');
    return view('mobile.profile.actions.invoice', compact('product'));
})->name('mobile.profile.actions.invoice');

Route::get('/mobile/orders/invoice-trip/{id}', function ($id) {
    $trip = UnpaidTripRequests::with('invoices')->find($id);
    if (!$trip) {
        $trip = TripRegistration::with('invoices')->find($id);
    }
    if (!$trip) {
        $trip = TripRequest::with('invoices')->find($id);
    }

    return view('mobile.profile.actions.invoice-trip', compact('trip'));
})->name('mobile.profile.actions.invoice-trip');

Route::get('/mobile/orders/invoice-trip-client/{id}', function ($id) {
    $trip = UnpaidTripRequests::with('invoices')->find($id)
        ?? TripRegistration::with('invoices')->find($id)
        ?? abort(404, 'الطلب غير موجود');

    return view('mobile.profile.actions.invoice-trip-client', compact('trip'));
})->name('mobile.profile.actions.invoice-trip-client');

Route::get('/mobile/orders/documents/{tripId}/show-trip/{documentId}', function ($tripId, $documentId) {
    $trip = TripRequest::find($tripId);

    $document = Document::findOrFail($documentId);
    return view('mobile.profile.actions.show_document-trip', compact('trip', 'document'));
})->name('mobile.profile.actions.show_document-trip');

Route::get('/mobile/orders/documents/{tripId}/show-trip-client/{documentId}', function ($tripId, $documentId) {
    $trip = UnpaidTripRequests::find($tripId);
    if (!$trip) {
        $trip = TripRegistration::find($tripId);
    }
    $document = Document::findOrFail($documentId);
    return view('mobile.profile.actions.show_document-trip-client', compact('trip', 'document'));
})->name('mobile.profile.actions.show_document-trip-client');

Route::get('/mobile/orders/documents/{productId}/show/{documentId}', function ($productId, $documentId) {
    $product = Product::findOrFail($productId);
    $document = Document::findOrFail($documentId);
    return view('mobile.profile.actions.show_document', compact('product', 'document'));
})->name('mobile.profile.actions.show_document');

Route::get('/mobile/orders/documents/{id}', function ($id) {
    $product = Product::findOrFail($id)->load('documents', 'notes');
    return view('mobile.profile.actions.doc', compact('product'));
})->name('mobile.profile.actions.doc');

Route::get('/mobile/orders/documents-trip/{id}', function ($id) {
    // $trip = TripRequest::findOrFail($id)->load('documents', 'notes');
    $trip = UnpaidTripRequests::with('documents')->find($id);
    if (!$trip) {
        $trip = TripRegistration::with('documents')->find($id);
    }
    if (!$trip) {
        $trip = TripRequest::with('documents')->find($id);
    }

    return view('mobile.profile.actions.doc-trip', compact('trip'));
})->name('mobile.profile.actions.doc-trip');

Route::get('/mobile/orders/documents-trip-client/{id}', function ($id) {

    $trip = UnpaidTripRequests::with('documents')->find($id);
    if (!$trip) {
        $trip = TripRegistration::with('documents')->find($id);
    }

    return view('mobile.profile.actions.doc-trip-client', compact('trip'));
})->name('mobile.profile.actions.doc-trip-client');

Route::get('/mobile/orders/orders-user/{product}', function (App\Models\Product $product) {
    $product->load('approvals', 'notes');
    return view('mobile.profile.order-display', compact('product'));
})->name('mobile.orders.show');

Route::get('/mobile/orders/orders-user-trip/{trip}', function ($tripId) {
    $trip = TripRequest::with('approvals', 'notes')->find($tripId);
    if (!$trip) {
        $trip = UnpaidTripRequests::with('approvals', 'notes')->find($tripId);
    }
    if (!$trip) {
        $trip = TripRegistration::with('approvals', 'notes')->find($tripId);
    }
    if (!$trip) {
        abort(404, 'الرحلة غير موجودة');
    }
    return view('mobile.profile.order-display-trip', compact('trip'));
})->name('mobile.orders.show-trip');

Route::middleware(['auth'])->group(function () {
    Route::post('/mobile/chat/send', [ChatController::class, 'sendMessage'])
        ->name('mobile.chat.send');
});

Route::post('/mobile/trip-chat/send', [ChatOrderController::class, 'sendTripMessage'])
    ->name('mobile.trip-chat.send');

Route::post('/mobile/chat/send', [ChatOrderController::class, 'sendMessage'])
    ->name('mobile.chat.order.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/mobile/chat', [ChatController::class, 'showUserChat'])->name('mobile.user.chat');
});

Route::middleware('auth')->group(function () {
    Route::get('mobile/chat', [ChatController::class, 'showUserChat'])->name('mobile.chat');
    Route::get('mobile/admin/all-chat', [ChatController::class, 'showAllChats'])->name('mobile.admin.all-chat');
    Route::get('mobile/admin/all-chat-profile', [ChatController::class, 'showAllChatsProfile'])->name('mobile.admin.all-chat-profile');
    Route::get('mobile/admin/chat/{chatUser}', [ChatController::class, 'showAdminChat'])->name('mobile.admin.chat');
    Route::post('mobile/chat/send', [ChatController::class, 'sendMessage'])->name('mobile.chat.send');
});

Route::middleware('mobile_auth')->group(function () {
    Route::get('/mobile/order/product/create', [ProductController::class, 'create'])
        ->name('mobile.order.product.create');
    Route::post('/mobile/order/product/store', [ProductController::class, 'store'])
        ->name('show.product.form');
    Route::get('/mobile/order/product/createProducts', [ProductController::class, 'createProducts'])
        ->name('mobile.order.product.createProducts');
    Route::post('/mobile/order/product/storeProducts', [ProductController::class, 'storeProducts'])
        ->name('mobile.order.product.storeProducts');
    Route::get('/mobile/order/product/success/{product}', [ProductController::class, 'success'])
        ->name('mobile.order.product.success');
});

Route::get('mobile.order.create', function () {
    $availableExplorers = Explorers::where('status', 'نشط')
        ->get()
        ->map(function ($explorer) {
            return [
                'id' => $explorer->id,
                'name' => (string) ($explorer->name_ar ?? $explorer->name ?? $explorer->full_name ?? $explorer->id ?? '') // غير حسب الحقل، و cast لـ string
            ];
        })
        ->toArray();
    return view('mobile.order.create', compact('availableExplorers'));
})->name('mobile.order.create');

Route::post('/trip-requests', [TripRequestController::class, 'store'])->name('trip-requests.store');
Route::get('/mobile/order/success', function () {
    return view('mobile.order.success');
})->name('mobile.order.success');

Route::get('/mobile/event', function () {
    $events = Event::where('status', 'نشط')
        ->where('end_date', '>', Carbon::now())->orderBy('end_date')->get();
    return view('mobile.welcome.event', compact('events'));
})->name('mobile.event');

Route::get('/mobile/trip-show1/{id}', function ($id) {
    $banner = Banner::where('is_active', 'نشط')->where('location', 'both', 'mobile_app')->first();
    $trip = Trip::with('activities.place.subCategory')->findOrFail($id);
    $activities = $trip->activities()
        ->with('place.subCategory')
        ->orderBy('date', 'asc')
        ->orderByRaw("CASE 
            WHEN period = 'morning' THEN 1 
            WHEN period = 'afternoon' THEN 2 
            WHEN period = 'evening' THEN 3 
            ELSE 4 END")
        ->get()
        ->groupBy('date');
    return view('mobile.welcome.trip-show1', compact('trip', 'banner', 'activities'));
})->name('mobile.trip-show1');

Route::get('/mobile/trip-show/{id}', function ($id) {
    $banner = Banner::where('is_active', 'نشط')->where('location', 'both')
        ->orWhere('location', 'mobile_app')->first();
    $trip = Trip::with('activities.place.subCategory')->findOrFail($id);
    $activities = $trip->activities()
        ->with('place.subCategory')
        ->orderBy('date', 'asc')
        ->orderByRaw("CASE 
            WHEN period = 'morning' THEN 1 
            WHEN period = 'afternoon' THEN 2 
            WHEN period = 'evening' THEN 3 
            ELSE 4 END")
        ->get()
        ->groupBy('date');
    return view('mobile.welcome.trip-show', compact('trip', 'banner', 'activities'));
})->name('mobile.trip-show');

Route::get('/mobile/trip', function () {
    $trips = Trip::all();
    return view('mobile.welcome.trip', compact('trips'));
})->name('mobile.trip');

Route::get('/mobile/order', function () {
    $orders = Adds::all();
    return view('mobile.welcome.order', compact('orders'));
})->name('mobile.order');

Route::get('/mobile/helpWords/{word_type?}', function ($word_type = 'تحية وتعريف') {
    if ($word_type) {
        $helpWords = HelpWord::where('status', 'نشط')
            ->where('word_type', $word_type)
            ->orderBy('order', 'asc')
            ->get();
    } else {
        $helpWords = HelpWord::where('status', 'نشط')->get();
    };
    return view('mobile.welcome.helpWords', compact('helpWords', 'word_type'));
})->name('mobile.helpWords');

Route::get('/mobile/howWeWork', function () {
    $howWeWork = Work::where('status', 'نشط')->first();
    return view('mobile.welcome.howWeWork', compact('howWeWork'));
})->name('mobile.howWeWork');

Route::get('/mobile/terms', function () {
    $terms = Terms::where('status', 'نشط')->first();
    return view('mobile.welcome.terms', compact('terms'));
})->name('mobile.terms');

Route::get('/mobile/privacy', function () {
    $privacy = Privacy::where('status', 'نشط')->first();
    return view('mobile.welcome.privacy', compact('privacy'));
})->name('mobile.privacy');

Route::get('/mobile/about', function () {
    $about = About::where('status', 'نشط')->first();
    return view('mobile.welcome.about', compact('about'));
})->name('mobile.about');

Route::get('/mobile/faq/{category?}', function ($category = 'الطلب') {
    $faqs = \App\Models\Faq::where('status', 'نشط')
        ->where('category', $category)
        ->orderBy('order', 'asc')
        ->get();
    return view('mobile.welcome.faq', compact('faqs', 'category'));
})->name('mobile.faq');

Route::post('/followers/toggle/{id}', [FollowersUserController::class, 'toggle'])
    ->name('followers.toggle');
Route::get('/mobile/followers', [FollowersUserController::class, 'index'])->name('mobile.profile.followers');
Route::post('/set-language', [LanguageController::class, 'setLanguage'])->name('set.language');
Route::post('/update-hidden-notifications', function (Request $request) {
    $hiddenNotifications = $request->input('hidden_notifications');
    Cookie::queue('hidden_notifications', $hiddenNotifications, 60 * 24 * 30);
    return response()->json(['status' => 'success']);
})->middleware('web');

Route::get('/mobile/notifications/search', [NotificationController::class, 'search'])
    ->name('mobile.notifications.search');

Route::get('/mobile/notifications', [NotificationController::class, 'index'])->name('mobile.notifications.index');
Route::get('/admin/fav_for_places/{place}', [FavForPlacesController::class, 'index'])
    ->name('admin.fav_for_places.index');
Route::delete('/admin/fav_for_places/{rating}', [FavForPlacesController::class, 'destroy'])->name('admin.fav_for_places.destroy');
Route::get('/admin/fav_places/{place}', [FavForPlacesController::class, 'fav_places'])
    ->name('admin.fav_places.index');

Route::get('/admin/all_favorites', [FavForPlacesController::class, 'allFavorites'])
    ->name('admin.all_favorites.index');
Route::post('/admin/reports/{id}/accept', [ReportController::class, 'acceptMobile'])->name('mobile.reports.accept');
Route::post('/admin/reports/{id}/dismiss', [ReportController::class, 'dismissMobile'])->name('mobile.reports.dismiss');

Route::get('/mobile/reports', [ReportController::class, 'mobileIndex'])->name('mobile.reports.index');
Route::get('/mobile/reports/{id}', [ReportController::class, 'mobileShow'])->name('mobile.reports.show');
Route::prefix('mobile/reports')->name('mobile.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'mobileIndex'])->name('index');
    Route::get('/{id}', [ReportController::class, 'mobileShow'])->name('show');
    Route::get('/{id}/review', [ReportController::class, 'mobileReviewShow'])->name('review_show');
    Route::post('/{id}/review/accept', [ReportController::class, 'reviewAccept'])->name('review_accept');
    Route::post('/{id}/review/dismiss', [ReportController::class, 'reviewDismiss'])->name('review_dismiss');
    Route::post('/', [ReportController::class, 'store'])->name('store');
    Route::post('/place/{placeId}', [ReportController::class, 'reportPlace'])->name('report_place');
});

Route::get('mobile/my-following', [
    FollowersUserController::class,
    'following'
])->name('mobile.profile.following')->middleware('auth');

Route::get('mobile/profile/discovers', function () {
    $users = User::withCount('followers')
        ->withCount('favorites')->withCount('ratings')->where('status', 1)
        ->where('role', 'user')->get();
    return view('mobile.profile.discovers', compact('users'));
})->name('mobile.profile.discovers')->middleware('mobile_auth');

Route::get('mobile/info_place/{place}', function (Places $place) {
    $place->loadCount('ratings');
    $place->loadAvg('ratings', 'rating');
    $hasReported = false;
    if (auth()->check()) {
        $hasReported = Report::where('user_id', Auth::id())
            ->where('place_id', $place->id)
            ->exists();
    }
    $followersCount = Followers::where('following_id', $place->user->id)->count();
    $placesCount = Places::where('user_id', $place->user_id)->count();
    $ratingCount = Rating::where('place_id', $place->id)->count();
    return view('mobile.china-discovers.info_place', compact('ratingCount', 'placesCount', 'followersCount', 'place', 'hasReported'));
})->name('mobile.china-discovers.info_place');

Route::get('/all-area-places/{branch_id}', [ChinaDiscoverController::class, 'allAreaPlaces'])->name('all-area-places');
Route::get('places/{place}/reviews', [RatingController::class, 'getReviews'])->name('places.reviews');
Route::get('mobile', function () {
    $banner = Banner::where('is_active', 'نشط')->where('location', 'website_home')
        ->orWhere('location', 'mobile_app')->first();
    $events = Event::where('status', 'نشط')->where('end_date', '>', Carbon::now())
        ->where('start_date', '<=', Carbon::now())->first();
    return view('mobile.welcome', compact('banner', 'events'));
})->name('mobile.welcome');
Route::get('mobile1', function () {
    $banner = Banner::where('is_active', 'نشط')->where('location', 'both', 'mobile_app')->first();
    $events = Event::where('status', 'نشط')->where('end_date', '>', Carbon::now())
        ->where('start_date', '<=', Carbon::now())->first();
    return view('mobile.welcome1', compact('banner', 'events'));
})->name('mobile.welcome1');
Route::middleware('mobile_auth')->group(function () {
    Route::get('mobile/all-places', function () {
        $allPlaces = Places::paginate(10);
        return view('mobile.admin.all-places', compact('allPlaces'));
    })->middleware('auth')->name('mobile.china-discovers.all-places');


    Route::get('mobile2', function () {
        $banner = Banner::where('is_active', 'نشط')->where('location', 'both', 'mobile_app')->first();
        return view('mobile.welcome2', compact('banner'));
    })->name('mobile.welcome2');

    Route::post('/users/toggle-follow', [FollowController::class, 'toggleFollow'])->name('users.toggle-follow');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
    Route::post('places/{place}/rate', [RatingController::class, 'store'])->name('places.rate');
    Route::post('api/places/{place}/rate', [RatingController::class, 'store']);
    Route::put('places/{place}/ratings/{rating}', [RatingController::class, 'updateRating'])->name('places.ratings.update');
    Route::delete('places/{place}/ratings/{rating}', [RatingController::class, 'deleteRating'])->name('places.ratings.delete');
    Route::post('places/{place}/report-review', [RatingController::class, 'reportReview'])->name('places.report-review');
    Route::post('places/{place}/report', [ReportController::class, 'reportPlace'])->name('places.report');
    Route::post('/chef-profile/report-by-user', [ReportController::class, 'store']);
    Route::get('mobile/my-places', function () {
        $myPlaces = Places::where('user_id', Auth::id())->get();
        return view('mobile.china-discovers.my-places', compact('myPlaces'));
    })->middleware('auth')->name('mobile.china-discovers.my-places');
    Route::get('mobile/my-interests', function () {
        $favoritePlaces = auth()->user()->favoritePlaces;
        return view('mobile.profile.my-interests', compact('favoritePlaces'));
    })->name('mobile.profile.my-interests');
    Route::post('/mobile/china-discovers/filter', [ChinaDiscoverController::class, 'filterPlaces'])
        ->name('mobile.china-discovers.filter');
    Route::get('mobile.create', [ChinaDiscoverController::class, 'create'])->name('mobile.create');

    Route::post('mobile/china-discovers', [ChinaDiscoverController::class, 'store'])->name('mobile.china-discovers.store');
    Route::get('mobile/china-discovers/edit/{id}', [ChinaDiscoverController::class, 'edit'])->name('mobile.china-discovers.edit');
    Route::put('mobile/china-discovers/{id}', [ChinaDiscoverController::class, 'update'])->name('mobile.china-discovers.update');
    Route::get('get-subcategories/{id}', [ChinaDiscoverController::class, 'getSubcategories'])->name('mobile.china-discovers.get-subcategories');
    Route::post('/translate', [ChinaDiscoverController::class, 'translate'])->name('translate');

    Route::post('mobile/china-discovers/filter-explorers', [ChinaDiscoverController::class, 'filterExplorers'])->name('mobile.china-discovers.filter-explorers');
    Route::get('mobile/china-discovers/all-sub-category', [ChinaDiscoverController::class, 'allSubCategory'])
        ->name('mobile.china-discovers.all-sub-category');
    Route::get('/all-sub-category/{explorer_id?}', [ChinaDiscoverController::class, 'allSubCategory'])
        ->name('all.sub-category');
    Route::delete('mobile/profile/delete-account', [ProfileController::class, 'deleteAccount'])->name('mobile.profile.delete-account');
    Route::post('mobile/profile/update', [ProfileController::class, 'updateProfile'])->name('mobile.profile.update');
    Route::post('mobile/profile/send-otp', [ProfileController::class, 'sendOtp'])->name('mobile.profile.send-otp');
    Route::post('mobile/profile/verify-otp', [ProfileController::class, 'verifyOtp'])->name('mobile.profile.verify-otp');
    Route::get('mobile/edit-profile', function () {
        return view('mobile.profile.edit-profile');
    })->name('mobile.profile.edit-profile');
    Route::get('mobile/verify', function () {
        return view('mobile.profile.verify');
    })->name('mobile.profile.verify');
    Route::get('mobile/success', function () {
        return view('mobile.profile.success');
    })->name('mobile.profile.success');
    Route::get('mobile/notifications', [NotificationController::class, 'index'])->name('mobile.profile.notifications');
    Route::get('mobile/notificationsUsers', [NotificationController::class, 'indexUsers'])->name('mobile.profile.notificationsUsers');
    Route::get('mobile/my-medals', function () {
        return view('mobile.profile.my-medals');
    })->name('mobile.profile.my-medals');
    // Route::get('mobile/china-discovers/all-places', [ChinaDiscoverController::class, 'allPlaces'])
    //     ->name('mobile.china-discovers.all--places');
    Route::get('/all-places/{region_id?}', [ChinaDiscoverController::class, 'allPlaces'])->name('mobile.china-discovers.all--places');
    Route::get('/new-places', [ChinaDiscoverController::class, 'newPlaces'])
        ->name('mobile.china-discovers.new-places');
    Route::get('/most-fav-places', [ChinaDiscoverController::class, 'mostPlaces'])
        ->name('mobile.china-discovers.most-fav-places');

    Route::get('mobile/profile', function () {
        $count = Places::where('user_id', Auth::user()->id)->count();
        $countInterests = Favorites::where('user_id', Auth::user()->id)->count();
        $activeUsers = User::where('status', 'active')->count();
        $myFollowers = Followers::where('follower_id', Auth::user()->id)->count();
        $iFollow = Followers::where('following_id', Auth::user()->id)->count();
        $all_orders = Product::where('user_id', Auth::user()->id)->count() + TripRequest::where('user_id', Auth::user()->id)->count();
        $user = Auth::user();

        // عدد اللي بيتابعوا المستخدم الحالي
        $UsersFollowMe = Followers::where('following_id', $user->id)->count();
        return view('mobile.profile.profile', compact('UsersFollowMe', 'all_orders', 'activeUsers', 'count', 'countInterests', 'myFollowers', 'iFollow'));
    })->name('mobile.profile.profile');


    Route::get('mobile/profileAdmin', function () {
        $all_places = Places::count();
        $all_users = User::count();
        $all_reports = Report::count();
        $count = Places::where('user_id', Auth::user()->id)->count();
        $countInterests = Favorites::where('user_id', Auth::user()->id)->count();
        $myFollowers = Followers::where('follower_id', Auth::user()->id)->count();
        $iFollow = Followers::where('following_id', Auth::user()->id)->count();
        $reports = Report::where('status', 'pending')->get();
        $review_reports = ReviewReport::where('status', 'pending')->get();
        $all_orders = Product::count() + TripRequest::count();
        $all_conversations = Message::count();
        return view('mobile.profile.profileAdmin', compact('all_conversations', 'all_orders', 'review_reports', 'reports', 'all_reports', 'all_users', 'all_places', 'count', 'countInterests', 'myFollowers', 'iFollow'));
    })->name('mobile.profile.profileAdmin');

    // Admin-specific routes
    // The mobile_auth middleware will also handle redirection if a regular user tries to access these.
    Route::get('mobile/admin/users/edit/{ad}', [UserAdminController::class, 'editFromMobile'])->name('mobile.admin.users.edit');
    Route::put('mobile/admin/users/update/{user}', [UserAdminController::class, 'updateFromMobile'])->name('mobile.admin.users.update');
    Route::delete('mobile/admin/users/destroy/{user}', [UserAdminController::class, 'destroyFromMobile'])->name('mobile.admin.users.destroy');
    Route::get('mobile/admin/users/index', function (Request $request) {
        $query = User::withCount('followers')->withCount('favorites')->withCount('ratings');
        if ($request->filled('search')) {
            $search_term = $request->input('search');
            $query->where('explorer_name', 'like', '%' . $search_term . '%');
        }
        $users = $query->get();
        return view('mobile.admin.users.index', compact('users'));
    })->name('mobile.admin.users.index');

    Route::get('mobile/users/discovers', function (Request $request) {
        $query = User::withCount('followers')->withCount('favorites')->withCount('ratings');
        if ($request->filled('search')) {
            $search_term = $request->input('search');
            $query->where('explorer_name', 'like', '%' . $search_term . '%');
        }
        $users = $query->get();
        return view('mobile.profile.discovers', compact('users'));
    })->name('mobile.users.index');
});
