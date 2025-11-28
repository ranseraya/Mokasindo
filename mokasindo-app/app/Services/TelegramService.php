<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->baseUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    public function sendMessage($chatId, $message)
    {
        // Validasi Token
        if (!$this->token) {
            return ['success' => false, 'error' => 'Token kosong di .env'];
        }

        try {
            // Kirim request ke API Telegram
            $response = Http::post($this->baseUrl . 'sendMessage', [
                'chat_id' => $chatId,
                'text'    => $message,
                'parse_mode' => 'HTML'
            ]);

            // Cek apakah Telegram menjawab "OK"
            if ($response->successful()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'Telegram Error: ' . $response->body()];
            }

        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Koneksi Error: ' . $e->getMessage()];
        }
    }
     //Kirim notifikasi ke User tertentu berdasarkan data database
    public function sendToUser($user, $message)
    {
        // Cek apakah user punya telegram_chat_id
        if (empty($user->telegram_chat_id)) {
            return ['success' => false, 'error' => 'User ini belum menautkan akun Telegram.'];
        }

        // Kalau ada, kirim pakai fungsi sendMessage yang lama
        return $this->sendMessage($user->telegram_chat_id, $message);
    }

}