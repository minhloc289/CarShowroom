<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary(); // Khóa chính dạng string
            $table->string('account_id'); // Khóa ngoại với bảng accounts
            $table->unsignedBigInteger('sale_id')->nullable(); // Khóa ngoại với bảng sales_cars
            $table->tinyInteger('status_order')->default(0); // 0: Chờ, 1: Thành công, 2: Hủy
            $table->date('order_date'); // Thêm cột ngày đặt hàng
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('sale_id')->references('sale_id')->on('sales_cars')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['sale_id']);
        });

        Schema::dropIfExists('orders');
    }
};
