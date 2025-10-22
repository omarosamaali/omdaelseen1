<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ChatOrderController;
use App\Http\Controllers\Admin\ChatController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders/{trip}/chat', [ChatController::class, 'show'])->name('admin.omdaHome.orders.chat');
    Route::post('/admin/orders/{trip}/chat/send', [ChatController::class, 'send'])->name('admin.omdaHome.orders.send');
});

Route::get('/mobile/orders/user-chat/{product_id}', [ChatOrderController::class, 'userChat'])
->name('mobile.profile.actions.user-chat');
Route::get('/mobile/orders/userAdminChat/{product_id}', [ChatOrderController::class, 'userAdminChat'])
->name('mobile.profile.actions.userAdminChat');

Route::get('/mobile/orders/userAdminChatTrip/{trip_id}', [ChatOrderController::class, 'userAdminChatTrip'])
    ->name('mobile.profile.actions.userAdminChatTrip');

Route::get('/mobile/orders/admin-chat/{product_id}', [ChatOrderController::class, 'adminChat'])
->name('mobile.profile.actions.admin-chat');

Route::get('/mobile/orders/admin-chat-trip/{trip_id}', [ChatOrderController::class, 'adminChatTrip'])
    ->name('mobile.profile.actions.admin-chat-trip');

Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/user/{user}/places/count', [OrderController::class, 'getUserPlacesCount'])->name('user.places.count');
    Route::get('/messages/{user}', [OrderController::class, 'messages'])->name('messages'); 

    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/admin/user/{user}/places/count', [OrderController::class, 'getUserPlacesCount']);
    Route::get('/admin/messages/{user}', [OrderController::class, 'messages']);
    
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
    Route::get('/createInvoice/{id}', [OrderController::class, 'createInvoice'])->name('createInvoice');
    Route::post('/store-invoice/{id}', [OrderController::class, 'storeInvoice'])->name('storeInvoice');
    Route::get('/show/{invoice_id}', [OrderController::class, 'showInvoice'])->name('showInvoice');
    Route::get('/bookingShow/{id}', [OrderController::class, 'bookingShow'])->name('bookingShow');
    
    Route::get('/note/{id}', [OrderController::class, 'note'])->name('note');
    Route::get('/createNote/{id}', [OrderController::class, 'createNote'])->name('createNote');
    Route::post('/store-note/{id}', [OrderController::class, 'storeNote'])->name('storeNote');
    Route::get('/showNote/{note_id}', [OrderController::class, 'showNote'])->name('showNote');
    Route::get('/editNote/{note_id}', [OrderController::class, 'editNote'])->name('editNote');
    Route::put('/update-note/{note_id}', [OrderController::class, 'updateNote'])->name('updateNote');
    Route::delete('/note/{note_id}', [OrderController::class, 'destroyNote'])->name('destroyNote');
    Route::get('/document/{id}', [OrderController::class, 'document'])->name('document');
    Route::get('/createDocument/{id}', [OrderController::class, 'createDocument'])->name('createDocument');
    Route::post('/store-document/{id}', [OrderController::class, 'storeDocument'])->name('storeDocument');
    Route::get('/showDocument/{document_id}', [OrderController::class, 'showDocument'])->name('showDocument');
    Route::get('/editDocument/{document_id}', [OrderController::class, 'editDocument'])->name('editDocument');
    Route::put('/update-document/{document_id}', [OrderController::class, 'updateDocument'])->name('updateDocument');
    Route::delete('/document/{document_id}', [OrderController::class, 'destroyDocument'])->name('destroyDocument');
    Route::get('/shippingNote/{id}', [OrderController::class, 'shippingNote'])->name('shippingNote');
    Route::get('/createShippingNote/{id}', [OrderController::class, 'createShippingNote'])->name('createShippingNote');
    Route::post('/store-shipping-note/{id}', [OrderController::class, 'storeShippingNote'])->name('storeShippingNote');
    Route::get('/showShippingNote/{shipping_note_id}', [OrderController::class, 'showShippingNote'])->name('showShippingNote');
    Route::get('/editShippingNote/{shipping_note_id}', [OrderController::class, 'editShippingNote'])->name('editShippingNote');
    Route::put('/update-shipping-note/{shipping_note_id}', [OrderController::class, 'updateShippingNote'])->name('updateShippingNote');
    Route::delete('/shipping-note/{shipping_note_id}', [OrderController::class, 'destroyShippingNote'])->name('destroyShippingNote');
    Route::get('/approval/{id}', [OrderController::class, 'approval'])->name('approval');
    Route::get('/createApproval/{id}', [OrderController::class, 'createApproval'])->name('createApproval');
    Route::post('/store-approval/{id}', [OrderController::class, 'storeApproval'])->name('storeApproval');
    Route::get('/showApproval/{approval_id}', [OrderController::class, 'showApproval'])->name('showApproval');
    Route::get('/editApproval/{approval_id}', [OrderController::class, 'editApproval'])->name('editApproval');
    Route::put('/update-approval/{approval_id}', [OrderController::class, 'updateApproval'])->name('updateApproval');
    Route::delete('/approval/{approval_id}', [OrderController::class, 'destroyApproval'])->name('destroyApproval');
    Route::put('/status/{id}', [OrderController::class, 'updateStatus'])->name('updateStatus');
    Route::put('/{id}', [OrderController::class, 'update'])->name('update');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('/{id}/product', [OrderController::class, 'showProduct'])->name('show-product');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
});
