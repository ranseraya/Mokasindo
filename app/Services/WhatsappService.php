<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public function sendMessage($target, $message)
    {
        // Ambil token dari .env (Nanti kita tambahkan)
        $token = env('FONNTE_TOKEN'); 

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error("Fonnte Error: " . $e->getMessage());
            return null;
        }
    }
}