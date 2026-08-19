<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'switch'])->name('lang.switch');

// Public Frontend Villa Pages
Route::get('/villa', [App\Http\Controllers\VillaController::class, 'index'])->name('villa.index');
Route::get('/villa/{property:slug}', [App\Http\Controllers\VillaController::class, 'show'])->name('villa.show');

// User Frontend Account & Booking Portal (Requires Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{property:slug?}', [App\Http\Controllers\BookingController::class, 'createPublic'])->name('booking.create');
    Route::post('/booking', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/check-promo', [App\Http\Controllers\PromoController::class, 'checkPromo'])->name('booking.check-promo');

    Route::get('/my-bookings', [App\Http\Controllers\UserBookingController::class, 'bookings'])->name('user.bookings');
    Route::post('/my-bookings/{booking:uuid}/cancel', [App\Http\Controllers\UserBookingController::class, 'cancel'])->name('user.bookings.cancel');
    Route::post('/reviews', [App\Http\Controllers\UserReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [App\Http\Controllers\UserReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [App\Http\Controllers\UserReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/my-account', [App\Http\Controllers\UserBookingController::class, 'account'])->name('user.account');
    Route::post('/my-account', [App\Http\Controllers\UserBookingController::class, 'updateAccount'])->name('user.account.update');
});

Route::get('/wisata', [App\Http\Controllers\HomeController::class, 'wisata'])->name('wisata.index');
Route::get('/layanan', [App\Http\Controllers\HomeController::class, 'layanan'])->name('layanan.index');

Route::get('/promo', [App\Http\Controllers\PromoController::class, 'index'])->name('promo.index');

// Route untuk memicu login Google
Route::get('/auth/google', [App\Http\Controllers\SocialiteController::class, 'redirectToGoogle'])->name('google.login');

// Route callback tempat Google mengirim data kembali
Route::get('/auth/google/callback', [App\Http\Controllers\SocialiteController::class, 'handleGoogleCallback']);

// Route Verifikasi Email Berbasis Kode OTP
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [App\Http\Controllers\Auth\OtpVerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/verify-otp', [App\Http\Controllers\Auth\OtpVerificationController::class, 'verify'])->name('verification.otp.verify');
    Route::post('/email/resend-otp', [App\Http\Controllers\Auth\OtpVerificationController::class, 'resend'])->name('verification.otp.resend');
});

Route::middleware(['auth', 'verified', 'role:Super Admin|Admin|admin|super-admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/user/role/{user}', [App\Http\Controllers\UserController::class, 'role'])->name('user.role');
    Route::post('/user/roleaction/{user}', [App\Http\Controllers\UserController::class, 'roleaction']);
    Route::resource('/user', App\Http\Controllers\UserController::class);

    Route::resource('/acount', App\Http\Controllers\AcountController::class)->only(['index', 'store']);
    Route::get('/acount/security', [App\Http\Controllers\AcountController::class, 'security'])->name('acount.security');
    Route::post('acount/password', [App\Http\Controllers\AcountController::class, 'updatePassword'])->name('acount.password');

    Route::post('/role/showaction/{role}', [App\Http\Controllers\RoleController::class, 'showaction']);
    Route::resource('/role', App\Http\Controllers\RoleController::class);


    Route::resource('/permissiongroup', App\Http\Controllers\PermissionGroupController::class)->except('show');

    Route::resource('/permission', App\Http\Controllers\PermissionController::class)->except('show');

    Route::resource('/menugroup', App\Http\Controllers\MenuGroupController::class)->except('show');
    Route::resource('/menu', App\Http\Controllers\MenuController::class)->except('show');
    Route::resource('/setting', App\Http\Controllers\SettingController::class)->only(['index', 'store']);

    Route::resource('/article_categories', App\Http\Controllers\ArticleCategoryController::class, ['parameters' => [
        'article_categories' => 'articleCategory:slug'
    ]])->except('show');

    Route::resource('/article', App\Http\Controllers\ArticleController::class)->parameters([
        'article' => 'article:slug',
    ]);

    Route::resource('/banner', App\Http\Controllers\BannerController::class)->parameters([
        'banner' => 'banner:uuid',
    ]);

    Route::resource('/destination', App\Http\Controllers\DestinationController::class)->parameters([
        'destination' => 'destination:uuid',
    ])->except('show');

    Route::resource('/properties', App\Http\Controllers\PropertiesController::class)->parameters([
        'properties' => 'property:slug',
    ])->except('show');
    Route::post('/resolve-maps-url', [App\Http\Controllers\PropertiesController::class, 'resolveMapsUrl'])->name('properties.resolve-maps');

    Route::resource('/property_services', App\Http\Controllers\PropertyServicesController::class)->parameters([
        'property_services' => 'property_service:uuid',
    ])->except('show');

    Route::resource('/facilities', App\Http\Controllers\FacilityController::class)->parameters([
        'facilities' => 'facility:uuid',
    ])->except('show');

    Route::resource('/property_rules', App\Http\Controllers\PropertyRuleController::class)->parameters([
        'property_rules' => 'property_rule:uuid',
    ])->except('show');

    Route::resource('/payment_methods', App\Http\Controllers\PaymentMethodController::class)->parameters([
        'payment_methods' => 'payment_method:uuid',
    ])->except('show');

    Route::resource('/promotion', App\Http\Controllers\PromotionController::class)->except('show');

    Route::resource('/bookings', App\Http\Controllers\BookingController::class)->parameters([
        'bookings' => 'booking:uuid',
    ])->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::patch('/bookings/{booking}/status', [App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::resource('/reviews', App\Http\Controllers\ReviewController::class)->parameters([
        'reviews' => 'review:uuid',
    ])->only(['index', 'edit', 'update', 'destroy']);

    // Admin Notifications
    Route::get('/admin/notifications/feed', [App\Http\Controllers\AdminNotificationController::class, 'feed'])->name('admin.notifications.feed');
    Route::get('/admin/notifications', [App\Http\Controllers\AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/admin/notifications/{notification:uuid}/read', [App\Http\Controllers\AdminNotificationController::class, 'read'])->name('admin.notifications.read');
    Route::post('/admin/notifications/mark-all-read', [App\Http\Controllers\AdminNotificationController::class, 'markAllRead'])->name('admin.notifications.mark-all-read');
    Route::delete('/admin/notifications/{notification:uuid}', [App\Http\Controllers\AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');





    // Route::prefix('setting')->group(function () {
    //     Route::get('/',[App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    //     Route::get('/create',[App\Http\Controllers\SettingController::class, 'create'])->name('setting.create');
    //     Route::post('/store',[App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');
    //     // Route::get('/edit/{setting}',[App\Http\Controllers\SettingController::class, 'edit'])->name('setting.edit');
    //     // Route::put('/update/{setting}',[App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
    //     Route::delete('/delete/{setting}',[App\Http\Controllers\SettingController::class, 'delete'])->name('setting.delete');
    // });
});
    