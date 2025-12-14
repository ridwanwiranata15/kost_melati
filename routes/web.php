<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyOrderCustomerController;
use App\Http\Controllers\TestimonialController;
use App\Models\Gallery;
use App\Models\Room;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Halaman utama
Route::get('/', function () {
    $rooms = Room::all();
    $galleries = Gallery::all();
    $testimonials = Testimonial::all();
    return view('welcome', compact('rooms', 'galleries', 'testimonials'));
})->name('home');

// Dashboard Admin
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

// Group khusus admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::redirect('settings', 'settings/profile');

    // Settings
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route(
        'settings/two-factor',
        'settings.two-factor'
    )
    ->middleware(
        when(
            Features::canManageTwoFactorAuthentication()
            && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
            ['password.confirm'],
            []
        )
    )
    ->name('two-factor.show');

    // Manajemen Room (Admin)
    Volt::route('rooms', 'room')->name('admin.room');

    // Edit Room (Admin) - dengan parameter
    Volt::route('room/{id}', 'roomindex')->name('admin.room.edit');
    Volt::route('users', 'user')->name('admin.user');
    Volt::route('user/{id}', 'detailuser')->name('admin.user.detail');
    Volt::route('booking', 'booking')->name('admin.booking');
    Volt::route('gallery', 'gallery')->name('admin.gallery');
});

// Customer Profile
Route::get('profile', function () {
    return view('customer.profile');
})->name('customer.profile');
Route::get('my-order', [MyOrderCustomerController::class, 'index'])->name('customer.order');


Route::post('/checkout', [BookingController::class, 'checkout'])->name('checkout');
Route::post('/booking', [BookingController::class, 'booking'])->name('booking');
Route::get('/booking/{id}', [MyOrderCustomerController::class, 'payment'])->name('booking.upload');
Route::put('/booking/{id}/update', [MyOrderCustomerController::class, 'paynow'])->name('booking.pay');
Route::get('testimonial', [TestimonialController::class, 'index'])->name('customer.testimonial');
Route::post('testimonial', [TestimonialController::class, 'store'])->name('customer.testimonial.store');
