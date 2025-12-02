<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (Siapa yang menyukai)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Kendaraan (Mobil mana yang disukai)
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();

            // Mencegah user menyukai mobil yang sama berkali-kali
            $table->unique(['user_id', 'vehicle_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};