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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->text('pickup_address');
            $table->text('destination_address');
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->string('courier_name')->nullable();
            $table->string('tracking_code')->nullable();
            $table->enum('status', ['pending', 'processing', 'on_delivery', 'delivered', 'confirmed'])->default('pending');
            $table->string('proof_of_delivery')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
