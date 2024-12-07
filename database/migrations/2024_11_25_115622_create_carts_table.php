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
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // ID tự động tăng, khóa chính
            $table->string('account_id'); // Khóa ngoại tới bảng accounts
            $table->unsignedBigInteger('accessory_id'); // Khóa ngoại tới bảng accessories
            $table->integer('quantity')->unsigned()->default(1); // Số lượng mua, mặc định là 1
            $table->timestamps(); // Tự động thêm created_at và updated_at

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('accessory_id')->references('accessory_id')->on('accessories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['account_id']); // Xóa khóa ngoại tới bảng accounts
            $table->dropForeign(['accessory_id']); // Xóa khóa ngoại tới bảng accessories
        });
    }
};
