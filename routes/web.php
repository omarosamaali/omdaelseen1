<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;
use App\Models\Banner;
use App\Models\About;
use App\Models\Work;
use App\Models\Privacy;
use App\Models\Terms;
use App\Models\Event;
use App\Models\Faq;
use App\Models\HelpWord;
use App\Models\Regions;

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\ExplorersController;
use App\Http\Controllers\Admin\RegionsController;
use App\Http\Controllers\Admin\BranchesController;
use App\Http\Controllers\Admin\PlacesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Admin\PrivacyController;
use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\HelpWordsController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Api\UserInterestController;

Route::post('/translate', [TranslationController::class, 'translate'])->name('translate');

Route::get('users/events/index', function () {
    $events = Event::where('type', 'معرض')->get();
    return view('users.events.index', compact('events'));
})->name('users.events.index');

Route::get('users/meet/index', function () {
    $events = Event::where('type', 'مناسبة')->get();
    return view('users.meet.index', compact('events'));
})->name('users.meet.index');

Route::prefix('admin/omdaHome/user_interests')->name('admin.user_interests.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\UserInterestController::class, 'index'])->name('index');
    Route::get('/{userInterest}', [App\Http\Controllers\Admin\UserInterestController::class, 'show'])->name('show');
    Route::delete('/{userInterest}', [App\Http\Controllers\Admin\UserInterestController::class, 'destroy'])->name('destroy');
});

Route::prefix('users/user_interests')->name('user.user_interests.')->group(function () {
    Route::get('/', [App\Http\Controllers\UserInterestController::class, 'index'])->name('index');
    Route::get('/{userInterest}', [App\Http\Controllers\UserInterestController::class, 'show'])->name('show');
    Route::delete('/{userInterest}', [App\Http\Controllers\UserInterestController::class, 'destroy'])->name('destroy');
});


// Without sanctum, using regular auth
Route::post('/api/user-interests', [App\Http\Controllers\Api\UserInterestController::class, 'store'])
    ->middleware('auth') 
    ->name('api.user_interests.store');

Route::prefix('admin/banners')->name('admin.banners.')->group(function () {
    Route::get('/', [BannerController::class, 'index'])->name('index');
    Route::get('/create', [BannerController::class, 'create'])->name('create');
    Route::post('/', [BannerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [BannerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BannerController::class, 'update'])->name('update');
    Route::get('/{id}', [BannerController::class, 'show'])->name('show');
    Route::delete('/{id}', [BannerController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [BannerController::class, 'deleteImage'])->name('delete-image');
});

Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
Route::prefix('admin/contact-messages')->name('admin.contact-messages.')->group(function () {
    Route::get('/', [ContactMessageController::class, 'index'])->name('index');
    Route::get('/{id}', [ContactMessageController::class, 'showAdmin'])->name('show');
    Route::delete('/{id}', [ContactMessageController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/status', [ContactMessageController::class, 'updateStatus'])->name('update-status');
});
Route::get('/contact', [ContactMessageController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactMessageController::class, 'submit'])->name('contact.submit');

Route::get('/test-email-view', function () {
    $contactMessage = new \App\Models\ContactMessage([
        'name' => 'Test Name',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'message' => 'This is a test message.',
        'receipt_date' => now(),
    ]);
    return view('emails.contact-notification', compact('contactMessage'));
});

Route::get('users/help_words/index', function () {
    $help_words = HelpWord::where('status', 1)->orderBy('order')->get();
    return view('users.help_words.index', compact('help_words'));
})->name('help_words.index');

Route::get('users/faq/index', function () {
    $faqs = Faq::where('status', 1)->orderBy('order')->get();
    return view('users.faq.index', compact('faqs'));
})->name('faq.index');


Route::get('users/meet/{event}', function (Event $event) {
    return view('users.meet.show', compact('event'));
})->name('users.meet.show');

Route::get('users/events/{event}', function (Event $event) {
    return view('users.events.show', compact('event'));
})->name('users.events.show');



Route::get('users/terms/index', function () {
    $terms = Terms::first();
    return view('users.terms.index', compact('terms'));
})->name('terms.index');

Route::get('users/privacy/index', function () {
    $privacy = Privacy::first();
    return view('users.privacy.index', compact('privacy'));
})->name('privacy.index');

Route::get('users/work/index', function () {
    $works = Work::first();
    return view('users.work.index', compact('works'));
})->name('work.index');

Route::get('users/about/index', function () {
    $abouts = About::first();
    return view('users.about.index', compact('abouts'));
})->name('about.index');

Route::get('user/explorers/index', function () {
    $banners = Banner::all();
    return view('user.explorers.index', compact('banners'));
})->name('user.index');

Route::get('users/omdaHome/index', function () {
    $banners = Banner::all();
    return view('users.omdaHome.index', compact('banners'));
})->name('omdaHome.index');

Route::prefix('admin/events')->name('admin.events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/create', [EventController::class, 'create'])->name('create');
    Route::post('/', [EventController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EventController::class, 'update'])->name('update');
    Route::get('/{id}', [EventController::class, 'show'])->name('show');
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [EventController::class, 'deleteImage'])->name('delete-image');
    
});

Route::prefix('admin/help_words')->name('admin.help_words.')->group(function () {
    Route::get('/', [HelpWordsController::class, 'index'])->name('index');
    Route::get('/create', [HelpWordsController::class, 'create'])->name('create');
    Route::post('/', [HelpWordsController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [HelpWordsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [HelpWordsController::class, 'update'])->name('update');
    Route::get('/{id}', [HelpWordsController::class, 'show'])->name('show');
    Route::delete('/{id}', [HelpWordsController::class, 'destroy'])->name('destroy');
    Route::post('/translate', [HelpWordsController::class, 'translate'])->name('translate');
});
// مسار لتوليد الملف الصوتي
Route::post('/generate-audio', [App\Http\Controllers\AudioController::class, 'generateAudio'])->name('generate.audio');

Route::prefix('admin/faq')->name('admin.faq.')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('index');
    Route::get('/create', [FaqController::class, 'create'])->name('create');
    Route::post('/', [FaqController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [FaqController::class, 'edit'])->name('edit');
    Route::put('/{id}', [FaqController::class, 'update'])->name('update');
    Route::get('/{id}', [FaqController::class, 'show'])->name('show');
    Route::delete('/{id}', [FaqController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/about')->name('admin.about.')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('index');
    Route::get('/create', [AboutController::class, 'create'])->name('create');
    Route::post('/', [AboutController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AboutController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AboutController::class, 'update'])->name('update');
    Route::get('/{id}', [AboutController::class, 'show'])->name('show');
    Route::delete('/{id}', [AboutController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [AboutController::class, 'deleteImage'])->name('delete-image');
});

Route::prefix('admin/terms')->name('admin.terms.')->group(function () {
    Route::get('/', [TermsController::class, 'index'])->name('index');
    Route::get('/create', [TermsController::class, 'create'])->name('create');
    Route::post('/', [TermsController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [TermsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [TermsController::class, 'update'])->name('update');
    Route::get('/{id}', [TermsController::class, 'show'])->name('show');
    Route::delete('/{id}', [TermsController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [TermsController::class, 'deleteImage'])->name('delete-image');
});

Route::prefix('admin/privacy')->name('admin.privacy.')->group(function () {
    Route::get('/', [PrivacyController::class, 'index'])->name('index');
    Route::get('/create', [PrivacyController::class, 'create'])->name('create');
    Route::post('/', [PrivacyController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PrivacyController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PrivacyController::class, 'update'])->name('update');
    Route::get('/{id}', [PrivacyController::class, 'show'])->name('show');
    Route::delete('/{id}', [PrivacyController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [PrivacyController::class, 'deleteImage'])->name('delete-image');
});

Route::prefix('admin/works')->name('admin.works.')->group(function () {
    Route::get('/', [WorkController::class, 'index'])->name('index');
    Route::get('/create', [WorkController::class, 'create'])->name('create');
    Route::post('/', [WorkController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [WorkController::class, 'edit'])->name('edit');
    Route::put('/{id}', [WorkController::class, 'update'])->name('update');
    Route::get('/{id}', [WorkController::class, 'show'])->name('show');
    Route::delete('/{id}', [WorkController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [WorkController::class, 'deleteImage'])->name('delete-image');
});

Route::prefix('admin/places')->name('admin.places.')->group(function () {
    Route::get('/', [PlacesController::class, 'index'])->name('index');
    Route::get('/create', [PlacesController::class, 'create'])->name('create');
    Route::post('/', [PlacesController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PlacesController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PlacesController::class, 'update'])->name('update');
    Route::get('/{id}', [PlacesController::class, 'show'])->name('show');
    Route::delete('/{id}', [PlacesController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [PlacesController::class, 'deleteImage'])->name('delete-image');
});
Route::prefix('users/places')->name('users.places.')->group(function () {
    Route::get('/', [App\Http\Controllers\PlacesController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\PlacesController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\PlacesController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\PlacesController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\PlacesController::class, 'update'])->name('update');
    Route::get('/{id}', [App\Http\Controllers\PlacesController::class, 'show'])->name('show');
    Route::delete('/{id}', [App\Http\Controllers\PlacesController::class, 'destroy'])->name('destroy');
    Route::post('/delete-image', [App\Http\Controllers\PlacesController::class, 'deleteImage'])->name('delete-image');
});

Route::prefix('admin/regions')->name('admin.regions.')->group(function () {
    Route::get('/', [RegionsController::class, 'index'])->name('index');
    Route::get('/create', [RegionsController::class, 'create'])->name('create');
    Route::post('/', [RegionsController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RegionsController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RegionsController::class, 'update'])->name('update');
    Route::get('/{id}', [RegionsController::class, 'show'])->name('show');
    Route::delete('/{id}', [RegionsController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/explorers')->name('admin.explorers.')->group(function () {
    Route::get('/', [ExplorersController::class, 'index'])->name('index');
    Route::get('/create', [ExplorersController::class, 'create'])->name('create');
    Route::post('/', [ExplorersController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ExplorersController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ExplorersController::class, 'update'])->name('update');
    Route::get('/{id}', [ExplorersController::class, 'show'])->name('show');
    Route::delete('/{id}', [ExplorersController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/branches')->name('admin.branches.')->group(function () {
    Route::get('/', [BranchesController::class, 'index'])->name('index');
    Route::get('/create', [BranchesController::class, 'create'])->name('create');
    Route::post('/', [BranchesController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [BranchesController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BranchesController::class, 'update'])->name('update');
    Route::get('/{id}', [BranchesController::class, 'show'])->name('show');
    Route::delete('/{id}', [BranchesController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [UserAdminController::class, 'index'])->name('index');
    Route::get('/create', [UserAdminController::class, 'create'])->name('create');
    Route::post('/', [UserAdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserAdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserAdminController::class, 'update'])->name('update');
    Route::get('/{id}', [UserAdminController::class, 'show'])->name('show');
    Route::delete('/{id}', [UserAdminController::class, 'destroy'])->name('destroy');
});

Route::get('/', function () {
    $banners = Banner::all();
    $event = Event::first();
return view('welcome', ['banners' => $banners, 'event' => $event]);
});

Route::get('/omdaHome
', function () {
    return view('omdaHome
');
});
Route::middleware('auth')->group(function () {
Route::get('/home', function () {
    return view('home');
})->name('home');
});

// Route::get('/home', function () {
//     return view('home');
// })->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
