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
        Schema::create('rental_receipt', function (Blueprint $table) {
            $table->id('receipt_id'); // Khóa chính tự động tăng
            $table->unsignedBigInteger('rental_id'); 
            $table->unsignedBigInteger('order_id'); // Liên kết với đơn hàng
            $table->dateTime('rental_start_date'); // Ngày bắt đầu thuê
            $table->dateTime('rental_end_date'); // Ngày kết thúc thuê
            $table->decimal('rental_price_per_day', 10, 2); // Giá thuê mỗi ngày
            $table->decimal('total_cost', 10, 2); // Tổng chi phí thuê
            $table->enum('status', ['Active', 'Canceled', 'Completed'])->default('Active'); // Trạng thái thuê xe
            $table->timestamps(); // Thời gian tạo và cập nhật
            
            // Khóa ngoại cho rental_id
            $table->foreign('rental_id')->references('rental_id')->on('rental_cars')->onDelete('cascade');

            // Khóa ngoại cho order_id
            $table->foreign('order_id')->references('order_id')->on('rental_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_receipt', function (Blueprint $table) {
            // Xóa khóa ngoại
            $table->dropForeign(['order_id']);
            $table->dropForeign(['rental_id']);
        });
        Schema::dropIfExists('rental_receipt');
        
    }
};
