<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /* Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('plan_id');
            $table->uuid('payment_id')->nullable();

            $table->string('ref_id')->unique()->nullable();

            $table->timestamp('start_date')->useCurrent();
            $table->date('end_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
        }); */
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
