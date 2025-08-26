<?php

use App\Filament\Admin\Pages\ConsultantTestDetails;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MarketerController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

//
Route::get('/', [LandingController::class, 'home'])->name('home');
Route::view('/contact', '')->name('contact');
Route::prefix('blog')->name('blog')->group(function () {
    Route::get('/tag/{tag}', [LandingController::class, 'blogTag'])->name('.tag.show');
    Route::get('/', [LandingController::class, 'blog']);
    Route::get('/archive/{year}/{month}', [LandingController::class, 'blogArchive'])->name('.archive');
    Route::get('/{slug}', [LandingController::class, 'blogDetail'])->name('.detail');
    Route::get('/category/{slug}', [PostCategoryController::class, 'show'])->name('.category.show');
    // Route::post('/{slug}/comment', [LandingController::class, 'storeComment'])->name('.comment.store');
});
Route::get('/wallet/callback', [WalletController::class, 'callback'])->name('wallet.callback');
Route::post('/send-to-gateway', [WalletController::class, 'SendToGateway'])->name('send.to.gateway');

// Consultant routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/consultant/test-details/{attempt}', ConsultantTestDetails::class)
        ->name('filament.admin.pages.consultant-test-details');

    // Consultant dashboard (outside Filament)
    Route::prefix('consultant')->name('consultant.')->middleware('role:consultant')->group(function () {
        Route::get('/dashboard', [ConsultantController::class, 'dashboard'])->name('dashboard');
        Route::get('/test/{attempt}', [ConsultantController::class, 'testDetails'])->name('test-details');
        Route::post('/test/{attempt}/response', [ConsultantController::class, 'storeResponse'])->name('store-response');
    });

    // Marketer dashboard (outside Filament)
    Route::prefix('marketer')->name('marketer.')->middleware('role:marketer')->group(function () {
        Route::get('/dashboard', [MarketerController::class, 'dashboard'])->name('dashboard');
        Route::get('/referrals', [MarketerController::class, 'referrals'])->name('referrals');
        Route::get('/commissions', [MarketerController::class, 'commissions'])->name('commissions');
    });
});

Route::get('/test/{slug}', [LandingController::class, 'testDetail'])->name('test.detail');
Route::prefix('tests')->name('tests.')->group(function () {
    Route::get('/', [LandingController::class, 'tests'])->name('index');
    Route::get('/archive/{year}/{month}', [LandingController::class, 'testArchive'])->name('archive');
    Route::get('/category/{slug}', [LandingController::class, 'testCategoryShow'])->name('category.show');
});

// Route::get('/tests/purchase/{slug}', [PaymentController::class, 'purchaseTest'])->name('tests.purchase');

Route::middleware('auth:sanctum')->prefix('user')->name('user.')->group(function () {

    Route::get('/test/start/{slug}', [TestController::class, 'startTest'])->name('test.start');
    Route::post('/test/submit/{slug}', [TestController::class, 'submitTest'])->name('test.submit');

    Route::prefix('wallet')->name('wallet.')->group(function () {
        Route::get('/charge', [WalletController::class, 'showChargeForm'])->name('charge.form');
        Route::post('/charge', [WalletController::class, 'sendToGateway'])->name('charge.submit');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('consultant')->name('consultant.')->group(function () {
        Route::put('/biography/update', [ProfileController::class, 'updateConsultantBiography'])->name('biography.update');
    });

    Route::prefix('family')->name('family.')->group(function () {
        Route::get('/show', [FamilyController::class, 'index'])->name('show');
        Route::get('/add', [FamilyController::class, 'add'])->name('add');
        Route::post('/create', [FamilyController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [FamilyController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [FamilyController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [FamilyController::class, 'destroy'])->name('delete');
    });

    Route::prefix('form-submissions')->name('form-submissions.')->group(function () {
        Route::post('/consultant', [FormSubmissionController::class, 'consultant'])->name('consultant');
        Route::post('/marketer', [FormSubmissionController::class, 'marketer'])->name('marketer');
    });

});

Route::controller(AuthController::class)
    ->middleware('guest')
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login-process', 'loginProcess')->name('login-process');
        Route::get('/register', 'register')->name('register');
        Route::post('/register-process', 'registerProcess')->name('register-process');
        Route::get('/reset-password', 'resetPassword')->name('reset-password');
    });

// redirects
Route::get('/login', function () {
    return redirect()->route('user.login');
})->name('login');
