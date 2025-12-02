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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->morphs('payable'); // untuk deposit atau transaction
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_code')->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_type', ['deposit', 'final_payment', 'refund']);
            $table->enum('payment_method', ['bank_transfer', 'qris', 'ovo', 'gopay', 'shopeepay', 'credit_card']);
            $table->enum('status', ['pending', 'processing', 'success', 'failed', 'expired', 'cancelled'])->default('pending');
            $table->string('payment_gateway')->nullable(); // midtrans, xendit, dll
            $table->string('payment_reference')->nullable();
            $table->text('payment_url')->nullable();
            $table->json('payment_details')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['payment_code', 'status']);
            $table->index(['user_id', 'payment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
