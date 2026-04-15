<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Locale switch
Route::get('/lang/{locale}', [PageController::class, 'switchLocale'])
    ->where('locale', 'ar|en')
    ->name('locale.switch');

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/apply', [PageController::class, 'apply'])->name('apply');

Route::get('/financing-request', [PageController::class, 'financingRequest'])->name('financing-request');
Route::post('/financing-request', [PageController::class, 'storeFinancingRequest'])->name('financing-request.store');

Route::get('/services', [PageController::class, 'services'])->name('services.index');
Route::get('/services/{slug}', [PageController::class, 'service'])->name('services.show');
Route::get('/offers/{slug}', [PageController::class, 'offer'])->name('offers.show');
Route::get('/articles/{slug}', [PageController::class, 'article'])->name('articles.show');

// Auth (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.update');
});

// Email verification (accessible to both guests and authenticated users)
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Auth (logged-in)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard',  [\App\Http\Controllers\ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/dashboard/applications/{application}', [\App\Http\Controllers\ClientDashboardController::class, 'show'])->name('client.applications.show');
    Route::get('/dashboard/profile',  [\App\Http\Controllers\ClientDashboardController::class, 'profile'])->name('client.profile');
    Route::post('/dashboard/profile', [\App\Http\Controllers\ClientDashboardController::class, 'updateProfile'])->name('client.profile.update');

    Route::get('/dashboard/financing/new',  [\App\Http\Controllers\ClientDashboardController::class, 'createFinancing'])->name('client.financing.create');
    Route::post('/dashboard/financing',     [\App\Http\Controllers\ClientDashboardController::class, 'storeFinancing'])->name('client.financing.store');

    // Financing Request (full feature)
    Route::prefix('dashboard/financing-request')->name('client.financing-request.')->group(function () {
        Route::get('/',                  [\App\Http\Controllers\FinancingRequestController::class, 'index'])->name('index');
        Route::get('/create',            [\App\Http\Controllers\FinancingRequestController::class, 'create'])->name('create');
        Route::post('/',                 [\App\Http\Controllers\FinancingRequestController::class, 'store'])->name('store');
        Route::post('/store-and-pay',    [\App\Http\Controllers\FinancingRequestController::class, 'storeAndPay'])->name('store_and_pay');
        Route::post('/sub-product',      [\App\Http\Controllers\FinancingRequestController::class, 'saveSubProductToSession'])->name('sub_product');
        Route::post('/track-step',       [\App\Http\Controllers\FinancingRequestController::class, 'trackStep'])->name('track-step');
        Route::get('/success/{id}',      [\App\Http\Controllers\FinancingRequestController::class, 'success'])->name('success');
        Route::get('/{req}',             [\App\Http\Controllers\FinancingRequestController::class, 'show'])->name('show')->whereNumber('req');
        Route::get('/{req}/offers',      [\App\Http\Controllers\FinancingRequestController::class, 'offers'])->name('offers')->whereNumber('req');
        Route::post('/{req}/select-offer', [\App\Http\Controllers\FinancingRequestController::class, 'selectOffer'])->name('select-offer')->whereNumber('req');

        // Payments
        Route::post('/payment/initiate',         [\App\Http\Controllers\ClickPayController::class, 'initiate'])->name('payment.initiate');
        Route::match(['get', 'post'], '/payment/callback', [\App\Http\Controllers\ClickPayController::class, 'callback'])->withoutMiddleware(['auth'])->name('payment.callback');
        Route::match(['get', 'post'], '/payment/return',   [\App\Http\Controllers\ClickPayController::class, 'return'])->name('payment.return');
        Route::get('/payment/success/{id}',      [\App\Http\Controllers\ClickPayController::class, 'paymentSuccess'])->name('payment.success');
        Route::get('/payment/failed/{id}',       [\App\Http\Controllers\ClickPayController::class, 'paymentFailed'])->name('payment.failed');
    });
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pages',         \App\Http\Controllers\Admin\PageController::class);
    Route::resource('services',      \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('banks',         \App\Http\Controllers\Admin\BankController::class);
    Route::resource('offers',        \App\Http\Controllers\Admin\OfferController::class);
    Route::resource('articles',      \App\Http\Controllers\Admin\ArticleController::class);
    Route::resource('faqs',          \App\Http\Controllers\Admin\FaqController::class);
    Route::resource('testimonials',  \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('trust-metrics', \App\Http\Controllers\Admin\TrustMetricController::class);
    Route::resource('steps',         \App\Http\Controllers\Admin\HowItWorksStepController::class);
    Route::resource('menus',         \App\Http\Controllers\Admin\MenuItemController::class);
    Route::resource('social',        \App\Http\Controllers\Admin\SocialLinkController::class);
    Route::resource('users',         \App\Http\Controllers\Admin\UserController::class);

    Route::get('content-blocks',            [\App\Http\Controllers\Admin\ContentBlockController::class, 'index'])->name('content-blocks.index');
    Route::post('content-blocks/bulk',      [\App\Http\Controllers\Admin\ContentBlockController::class, 'update'])->name('content-blocks.update');
    Route::get('content-blocks/create',     [\App\Http\Controllers\Admin\ContentBlockController::class, 'create'])->name('content-blocks.create');
    Route::post('content-blocks',           [\App\Http\Controllers\Admin\ContentBlockController::class, 'store'])->name('content-blocks.store');
    Route::delete('content-blocks/{contentBlock}', [\App\Http\Controllers\Admin\ContentBlockController::class, 'destroy'])->name('content-blocks.destroy');

    Route::get('settings',          [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings',         [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

    Route::get('applications',              [\App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}', [\App\Http\Controllers\Admin\ApplicationController::class, 'show'])->name('applications.show');
    Route::patch('applications/{application}', [\App\Http\Controllers\Admin\ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('applications/{application}', [\App\Http\Controllers\Admin\ApplicationController::class, 'destroy'])->name('applications.destroy');

    Route::get('contacts',              [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}',    [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}',  [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('media',             [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
    Route::post('media',            [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{media}',  [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');
});
