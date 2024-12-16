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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id('payment_details_id'); // Khóa chính tự động tăng
            $table->date('date'); // Ngày đặt cọc
            $table->unsignedBigInteger('sale_id'); // ID sale từ bảng sales_cars
            $table->decimal('deposit_amount', 15, 2); // Số tiền đặt cọc
            $table->decimal('remaining_amount', 15, 2)->nullable(); // Số tiền còn lại
            $table->date('due_date')->nullable(); // Hạn chót thanh toán
            $table->timestamps(); // Thời gian tạo và cập nhật
            // Ràng buộc khóa ngoại
            $table->foreign('sale_id')->references('sale_id')->on('sales_cars')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_details', function (Blueprint $table){
            $table->dropForeign(['sale_id']);
        });
        Schema::dropIfExists('payment_details');
    }
};

