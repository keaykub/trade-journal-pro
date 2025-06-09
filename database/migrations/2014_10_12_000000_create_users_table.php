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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('timezone')->default('Asia/Bangkok');
            $table->string('base_currency')->default('USD');
            $table->string('date_format')->default('DD/MM/YYYY');
            $table->string('time_format')->default('24h');
            $table->string('language')->default('th');
            $table->decimal('default_lot_size', 10, 2)->default(0.1);
            $table->decimal('risk_percentage', 5, 2)->default(2.0);
            $table->boolean('auto_calculate_rr')->default(true);
            $table->boolean('show_pips')->default(true);
            $table->boolean('email_notifications')->default(true);
            $table->boolean('daily_reminder')->default(true);
            $table->boolean('weekly_report')->default(true);
            $table->boolean('trade_alerts')->default(false);
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('profile_visibility')->default('private');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
