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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['anggota', 'member', 'admin', 'owner'])->default('anggota')->after('email');
            $table->string('phone', 20)->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete()->after('address');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete()->after('province_id');
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete()->after('city_id');
            $table->foreignId('sub_district_id')->nullable()->constrained('sub_districts')->nullOnDelete()->after('district_id');
            $table->string('postal_code', 10)->nullable()->after('sub_district_id');
            $table->string('avatar')->nullable()->after('postal_code');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->timestamp('verified_at')->nullable()->after('email_verified_at');
            $table->integer('weekly_post_count')->default(0)->after('is_active');
            $table->timestamp('last_post_reset')->nullable()->after('weekly_post_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'address', 'province_id', 'city_id', 
                'district_id', 'sub_district_id', 'postal_code', 'avatar', 
                'is_active', 'verified_at', 'weekly_post_count', 'last_post_reset'
            ]);
        });
    }
};
