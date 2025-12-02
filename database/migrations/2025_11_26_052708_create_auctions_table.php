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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->decimal('starting_price', 15, 2);
            $table->decimal('current_price', 15, 2)->default(0);
            $table->decimal('reserve_price', 15, 2)->nullable(); // harga minimal
            $table->decimal('deposit_amount', 15, 2); // 5% dari starting price
            $table->decimal('deposit_percentage', 5, 2)->default(5.00);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('duration_hours')->default(24); // durasi dalam jam
            $table->enum('status', ['scheduled', 'active', 'ended', 'sold', 'cancelled', 'reopened'])->default('scheduled');
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('won_at')->nullable();
            $table->timestamp('payment_deadline')->nullable(); // 24 jam setelah menang
            $table->integer('payment_deadline_hours')->default(24);
            $table->boolean('payment_completed')->default(false);
            $table->timestamp('payment_completed_at')->nullable();
            $table->integer('total_bids')->default(0);
            $table->integer('total_participants')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'start_time', 'end_time']);
            $table->index('winner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
