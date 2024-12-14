<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('payment_id')->primary(); // Khóa chính dạng string
            $table->string('order_id'); // Khóa ngoại với bảng orders
            $table->string('VNPAY_ID')->nullable();
            $table->date('payment_deposit_date')->nullable(); // Hạn đặt cọc
            $table->tinyInteger('status_deposit')->default(0); // 0: Chờ, 1: Thành công, 2: Hủy
            $table->tinyInteger('status_payment_all')->default(0); // 0: Chờ, 1: Thành công, 2: Hủy
            $table->decimal('deposit_amount', 10, 2); // Tiền cọc
            $table->decimal('remaining_amount', 10, 2); // Tiền còn lại
            $table->decimal('total_amount', 10, 2); // Tiền tổng
            $table->date('deposit_deadline'); // Hạn đặt cọc
            $table->date('payment_deadline'); // Hạn thanh toán
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
        });
    
        Schema::dropIfExists('payments');
    }
    
    
};
