<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_stats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('period_type');
            $table->date('period_date');

            $table->integer('total_trades')->default(0);
            $table->integer('win_trades')->default(0);
            $table->integer('loss_trades')->default(0);
            $table->integer('breakeven_trades')->default(0);

            $table->decimal('total_pnl', 12, 2)->default(0);
            $table->decimal('gross_profit', 12, 2)->default(0);
            $table->decimal('gross_loss', 12, 2)->default(0);
            $table->decimal('largest_win', 12, 2)->default(0);
            $table->decimal('largest_loss', 12, 2)->default(0);

            $table->decimal('win_rate', 5, 2)->default(0);
            $table->decimal('profit_factor', 8, 4)->default(0);
            $table->decimal('avg_risk_reward', 5, 2)->default(0);

            $table->integer('avg_hold_time_minutes')->default(0);
            $table->integer('max_consecutive_wins')->default(0);
            $table->integer('max_consecutive_losses')->default(0);
            $table->decimal('max_drawdown', 12, 2)->default(0);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'period_type', 'period_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_stats');
    }
};
