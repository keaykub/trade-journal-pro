<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('symbol');
            $table->string('order_type');
            $table->string('order_category')->default('market');
            $table->date('entry_date');
            $table->time('entry_time')->nullable();
            $table->date('exit_date')->nullable();
            $table->time('exit_time')->nullable();
            $table->decimal('entry_price', 12, 6);
            $table->decimal('exit_price', 12, 6)->nullable();
            $table->decimal('stop_loss', 12, 6)->nullable();
            $table->decimal('take_profit', 12, 6)->nullable();
            $table->decimal('lot_size', 10, 4);
            $table->decimal('pnl', 12, 2)->nullable();
            $table->decimal('pips', 8, 2)->nullable();
            $table->decimal('risk_reward', 5, 2)->nullable();
            $table->decimal('commission', 8, 2)->default(0);
            $table->decimal('swap', 8, 2)->default(0);
            $table->string('result')->nullable();
            $table->string('strategy')->nullable();
            $table->string('custom_strategy')->nullable();
            $table->string('emotion_before')->nullable();
            $table->string('emotion_after')->nullable();
            $table->text('notes')->nullable();
            $table->json('images')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_demo')->default(false);
            $table->boolean('is_shared')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
