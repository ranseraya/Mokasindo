<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            // Menambahkan kolom baru ke tabel auctions yang sudah ada
            $table->foreignId('auction_schedule_id')->nullable()->constrained('auction_schedules')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropForeign(['auction_schedule_id']);
            $table->dropColumn('auction_schedule_id');
        });
    }
};
