<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsappService; // Panggil Service yang baru kita buat

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $sender = $request->input('sender');
        $message = trim($request->input('message'));
        
        $wa = new WhatsappService(); // Inisialisasi Service

        // LOGIKA: Jika pesan diawali "REG-"
        if (str_starts_with(strtoupper($message), 'REG-')) {
            
            // Cari user yang punya kode tersebut
            $user = User::where('verification_code', $message)->first();

            if ($user) {
                // UPDATE USER JADI AKTIF
                $user->update([
                    'phone' => $sender, // Update nomor HP sesuai pengirim asli
                    'is_active' => true,       // Aktifkan akun
                    'verification_code' => null // Hapus kode
                ]);

                // Balas Pesan
                $wa->sendMessage($sender, "✅ Selamat {$user->name}! Akun Mokasindo Anda berhasil diaktifkan. Silakan kembali ke website, Anda akan login otomatis.");
            } else {
                $wa->sendMessage($sender, "❌ Kode verifikasi salah atau kadaluarsa.");
            }
        } 
        
        return "OK";
    }
}