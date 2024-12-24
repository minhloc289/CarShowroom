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
        Schema::table('rental_orders', function (Blueprint $table) {
            $table->boolean('renew_order')->default(false)->after('status'); // Thêm cột renew_order, mặc định là false
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_orders', function (Blueprint $table) {
            $table->dropColumn('renew_order'); // Xóa cột renew_order khi rollback
        });
    }
};
