<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WishlistController;
use App\Models\Page;

Route::get('/', function () {
    return view('landing');
});

Route::prefix('etalase')->group(function () {
    Route::get('/filters', [VehicleController::class, 'filters']);
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/wishlists', [WishlistController::class, 'index']);
    Route::post('/wishlists', [WishlistController::class, 'store']);
    Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy']);
});

// ====================================================
// Company Routes (Temporary Empty Routes)
// ====================================================
Route::prefix('company')->name('company.')->group(function () {
    Route::get('/about', function () {
        return '<h1>About Us - Coming Soon</h1>';
    })->name('about');
    
    Route::get('/faq', function () {
        return '<h1>FAQ - Coming Soon</h1>';
    })->name('faq');
    
    Route::get('/career', function () {
        return '<h1>Career - Coming Soon</h1>';
    })->name('career');
    
    Route::get('/career/{id}', function ($id) {
        return '<h1>Career Detail - Coming Soon</h1>';
    })->name('career.detail');
    
    Route::post('/career/{id}/apply', function ($id) {
        return redirect()->back()->with('success', 'Application submitted - Coming Soon');
    })->name('career.apply');
    
    Route::get('/contact', function () {
        return '<h1>Contact Us - Coming Soon</h1>';
    })->name('contact');
    
    Route::post('/contact', function () {
        return redirect()->back()->with('success', 'Message sent - Coming Soon');
    })->name('contact.store');
    
    Route::get('/how-it-works', function () {
        return '<h1>How It Works - Coming Soon</h1>';
    })->name('how_it_works');
    
    Route::get('/terms', function () {
        return '<h1>Terms & Conditions - Coming Soon</h1>';
    })->name('terms');
    
    Route::get('/privacy', function () {
        return '<h1>Privacy Policy - Coming Soon</h1>';
    })->name('privacy');
    
    Route::get('/cookie-policy', function () {
        return '<h1>Cookie Policy - Coming Soon</h1>';
    })->name('cookie_policy');
    
    Route::get('/career/{id}/detail', function ($id) {
        return '<h1>Career Detail - Coming Soon</h1>';
    })->name('career.show');
    
    Route::post('/career/{id}/submit', function ($id) {
        return redirect()->back()->with('success', 'Application submitted - Coming Soon');
    })->name('career.store');
});

// ====================================================
// 4. HELPER TESTING (Force Login)
// ====================================================
// Jalankan URL ini sekali di browser agar kamu login otomatis sebagai ID 1 (http://mokasindo.test/force-login)

Route::get('/force-login', function () {
    $user = \App\Models\User::find(1);
    
    if (!$user) {
        // Buat user dummy jika belum ada
        $user = \App\Models\User::create([
            'id' => 1,
            'name' => 'Tester User',
            'email' => 'tester@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    Auth::login($user);
    
    return "<h1>Berhasil Login!</h1> <p>Login sebagai: <b>" . $user->name . "</b></p><p>Silakan akses <a href='/wishlists'>/wishlists</a> atau <a href='/etalase/vehicles'>/etalase/vehicles</a></p>";
});
