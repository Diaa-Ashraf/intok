<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ModeratorController;
use App\Http\Controllers\Admin\SitePageController as AdminSitePageController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ServicePageController;
use App\Http\Controllers\Public\ClientLeadController;
use App\Http\Controllers\Public\PublicSeoController;
use App\Http\Controllers\Public\SitePageController as PublicSitePageController;
use App\Http\Controllers\Public\TestimonialPageController;

Route::redirect('/', '/ar');
Route::get('/sitemap.xml', [PublicSeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PublicSeoController::class, 'robots'])->name('robots');

Route::prefix('{locale}')
    ->whereIn('locale', ['ar', 'en', 'it'])
    ->group(function (): void {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/about', [PublicSitePageController::class, 'about'])->name('about');
        Route::get('/team', [\App\Http\Controllers\Public\TeamPageController::class, 'index'])->name('team');
        Route::get('/testimonials', [TestimonialPageController::class, 'index'])->name('testimonials');
        Route::get('/p/{slug}', [PublicSitePageController::class, 'show'])->name('pages.show');
        Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');
        Route::get('/services/{slug}', [ServicePageController::class, 'show'])->name('services.show');
        Route::get('/contact', [ContactController::class, 'create'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');
        Route::get('/register', [ClientLeadController::class, 'registrationForm'])->name('registration.create');
        Route::post('/register', [ClientLeadController::class, 'register'])->middleware('throttle:5,1')->name('registration.store');
        Route::get('/consultation', [ClientLeadController::class, 'consultationForm'])->name('consultation.create');
        Route::post('/consultation', [ClientLeadController::class, 'book'])->middleware('throttle:5,1')->name('consultation.store');
    });

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
    Route::get('/admin/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/admin/forgot-password', [PasswordResetController::class, 'sendLink'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/admin/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/admin/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::get('/inquiries/export', [InquiryController::class, 'export'])->name('inquiries.export');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'update'])->name('bookings.status');
    Route::get('/bookings/export', [BookingController::class, 'export'])->name('bookings.export');
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/status', [RegistrationController::class, 'update'])->name('registrations.status');
    Route::get('/registrations/export', [RegistrationController::class, 'export'])->name('registrations.export');
    Route::middleware('role:Admin')->group(function (): void {
        Route::resource('moderators', ModeratorController::class)->parameters(['moderators' => 'moderator'])->except(['show']);
        Route::resource('pages', AdminSitePageController::class)->except(['show']);
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
        Route::get('/settings', [SiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingsController::class, 'update'])->name('settings.update');
    });
    Route::middleware('role:Admin')->group(function (): void {
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::resource('team', TeamMemberController::class)->parameters(['team' => 'teamMember'])->except(['show']);
    });
});
