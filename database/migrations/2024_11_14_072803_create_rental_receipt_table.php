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
            $table->unsignedBigInteger('user_id'); // user_id mà không có ràng buộc khóa ngoại
            $table->unsignedBigInteger('car_id'); // car_id mà không có ràng buộc khóa ngoại
            $table->dateTime('rental_start_date')->notNullable(); // Ngày bắt đầu thuê
            $table->dateTime('rental_end_date')->notNullable(); // Ngày kết thúc thuê
            $table->decimal('rental_price_per_day', 10, 2)->notNullable(); // Giá thuê mỗi ngày
            $table->decimal('total_cost', 10, 2)->notNullable(); // Tổng chi phí thuê
            $table->enum('status', ['Active', 'Completed', 'Canceled'])->default('Active'); // Trạng thái
            $table->timestamps(); // Thời gian tạo và cập nhật
            
            // Thêm khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('account')->onDelete('cascade');

            // Thêm khóa ngoại cho car_id
            $table->foreign('car_id')->references('rental_id')->on('rental_cars')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_receipt');
        Schema::table('rental_receipt', function (Blueprint $table) {
            // Xóa khóa ngoại
            $table->dropForeign(['user_id']);
            $table->dropForeign(['car_id']);
        });
    }
};
