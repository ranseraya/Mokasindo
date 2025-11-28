<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Models\Page;
use App\Models\User;

Route::get('/', function () {
    return view('landing');
});

// Group Route Company
Route::controller(CompanyController::class)->group(function () {
    Route::get('/about', 'about')->name('company.about');
    Route::get('/faq', 'faq')->name('company.faq');
    Route::get('/contact', 'contact')->name('company.contact');
    Route::post('/contact', 'storeContact')->name('company.contact.store');

    Route::get('/careers', 'career')->name('company.career');
    Route::get('/careers/{id}', 'careerDetail')->name('company.career.show');
    Route::post('/careers/{id}/apply', 'storeCareerApplication')->name('company.career.store');

    Route::get('/terms', function () {
        $page = Page::findBySlug('terms');
        return view('pages.company.generic', compact('page'));
    })->name('company.terms');

    Route::get('/privacy', function () {
        $page = Page::findBySlug('privacy-policy');
        return view('pages.company.generic', compact('page'));
    })->name('company.privacy');

    Route::get('/how-it-works', function () {
        $page = Page::findBySlug('how-it-works');
        return view('pages.company.generic', compact('page'));
    })->name('company.how_it_works');

    Route::get('/cookie-policy', function () {
        $page = Page::findBySlug('cookie-policy');
        return view('pages.company.generic', compact('page'));
    })->name('company.cookie_policy');

});

use App\Services\TelegramService;

// --- AREA TESTING (BOT) ---
Route::get('/tes-bot', function () {
    $telegram = new TelegramService();
    
    // Chat ID dari @userinfobot
    $chatIdSaya = '6179231520'; 

    // --- DESAIN PESAN ---
    
    $pesan = "<b>🔔 MOKASINDO NOTIFICATION</b>\n\n" .
             "Halo, <b>Surya Afriza</b>! 👋\n" .
             "Akun Telegram Anda berhasil terhubung dengan sistem lelang kami.\n\n" .
             "📅 <b>Waktu Akses:</b> " . date('d F Y, H:i') . " WIB\n" .
             "✅ <b>Status:</b> TERVERIFIKASI\n\n" .
             "<i>Sekarang Anda akan menerima update lelang secara realtime.</i>\n" .
             "--------------------------------\n" .
             "🔗 <a href='http://127.0.0.1:8000'>Buka Website Mokasindo</a>";
    
    // Kirim pesan
    $hasil = $telegram->sendMessage($chatIdSaya, $pesan);
    
    // Cek hasil
    if ($hasil['success']) {
        return "✅ Sukses! Notifikasi keren sudah dikirim ke HP kamu.";
    } else {
        return "❌ Gagal Kirim! <br>Penyebab: " . $hasil['error'];
    }
});

// --- TES DATABASE ---
Route::get('/tes-db-notif', function () {
    $telegram = new TelegramService();
    
    // 1. Ambil User pertama dari database (yang tadi kamu edit di phpMyAdmin)
    $user = User::first(); 
    
    // Cek apakah usernya ketemu
    if (!$user) {
        return "Database kosong! Jalankan 'php artisan migrate:fresh --seed' dulu.";
    }

    $pesan = "Halo <b>{$user->name}</b>! \nSistem berhasil menemukan ID Telegram kamu dari Database Mokasindo. Keren kan? 😎";

    // 2. Kirim notifikasi ke user tersebut
    $hasil = $telegram->sendToUser($user, $pesan);

    if ($hasil['success']) {
        return "✅ Sukses kirim ke user: " . $user->name;
    } else {
        return "❌ Gagal: " . $hasil['error'];
    }
});

