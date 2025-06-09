<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->string('share_token', 64)->nullable()->unique()->after('id');
            $table->boolean('is_public')->default(false)->after('share_token');
            $table->timestamp('shared_at')->nullable()->after('is_public');
            $table->unsignedInteger('view_count')->default(0)->after('shared_at');
            $table->json('share_settings')->nullable()->after('view_count');

            // เพิ่ม index สำหรับ performance
            $table->index(['is_public', 'shared_at']);
            $table->index('share_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropIndex(['is_public', 'shared_at']);
            $table->dropIndex(['share_token']);

            $table->dropColumn([
                'share_token',
                'is_public',
                'shared_at',
                'view_count',
                'share_settings'
            ]);
        });
    }
};

/*
คำสั่งสร้าง migration:
php artisan make:migration add_sharing_columns_to_trades_table

คำสั่งรัน migration:
php artisan migrate
*/
