<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Auction Settings
            [
                'key' => 'auction_deposit_percentage',
                'value' => '5',
                'type' => 'integer',
                'group' => 'auction',
                'description' => 'Persentase deposit yang harus dibayar untuk ikut lelang',
                'is_public' => true,
            ],
            [
                'key' => 'auction_payment_deadline_hours',
                'value' => '24',
                'type' => 'integer',
                'group' => 'auction',
                'description' => 'Batas waktu pelunasan setelah menang lelang (dalam jam)',
                'is_public' => true,
            ],
            [
                'key' => 'auction_default_duration_hours',
                'value' => '24',
                'type' => 'integer',
                'group' => 'auction',
                'description' => 'Durasi default lelang dalam jam',
                'is_public' => true,
            ],
            [
                'key' => 'auction_forfeit_owner_percentage',
                'value' => '60',
                'type' => 'integer',
                'group' => 'auction',
                'description' => 'Persentase deposit hangus untuk pemilik kendaraan',
                'is_public' => false,
            ],
            [
                'key' => 'auction_forfeit_platform_percentage',
                'value' => '40',
                'type' => 'integer',
                'group' => 'auction',
                'description' => 'Persentase deposit hangus untuk platform',
                'is_public' => false,
            ],
            
            // Member Settings
            [
                'key' => 'anggota_weekly_post_limit',
                'value' => '2',
                'type' => 'integer',
                'group' => 'member',
                'description' => 'Batas posting per minggu untuk anggota',
                'is_public' => true,
            ],
            
            // Platform Settings
            [
                'key' => 'platform_fee_percentage',
                'value' => '2.5',
                'type' => 'decimal',
                'group' => 'general',
                'description' => 'Persentase fee platform dari transaksi',
                'is_public' => false,
            ],
            [
                'key' => 'app_name',
                'value' => 'Mokasindo',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nama aplikasi',
                'is_public' => true,
            ],
            [
                'key' => 'app_email',
                'value' => 'info@mokasindo.com',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Email aplikasi',
                'is_public' => true,
            ],
            [
                'key' => 'app_phone',
                'value' => '081234567890',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nomor telepon aplikasi',
                'is_public' => true,
            ],
            
            // Notification Settings
            [
                'key' => 'notification_email_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'description' => 'Enable notifikasi email',
                'is_public' => false,
            ],
            [
                'key' => 'notification_whatsapp_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'description' => 'Enable notifikasi WhatsApp',
                'is_public' => false,
            ],
            [
                'key' => 'notification_telegram_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'description' => 'Enable notifikasi Telegram',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
