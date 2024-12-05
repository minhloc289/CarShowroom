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
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('name')->nullable(); // Thêm cột họ tên
            $table->string('address')->nullable(); // Thêm cột địa chỉ
            $table->string('phone', 15)->nullable(); // Thêm cột số điện thoại
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['name', 'address', 'phone']); // Xóa các cột khi rollback
        });
    }
};
