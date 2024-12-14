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
            $table->string('user_id'); // user_id với kiểu string để phù hợp với id trong bảng accounts
            $table->unsignedBigInteger('rental_id'); // car_id mà không có ràng buộc khóa ngoại
            $table->dateTime('rental_start_date')->notNullable(); // Ngày bắt đầu thuê
            $table->dateTime('rental_end_date')->notNullable(); // Ngày kết thúc thuê
            $table->decimal('rental_price_per_day', 10, 2)->notNullable(); // Giá thuê mỗi ngày
            $table->decimal('total_cost', 10, 2)->notNullable(); // Tổng chi phí thuê
            $table->decimal('deposit_amount', 10, 2)->default(0); // Số tiền đặt cọc đã thanh toán
            $table->decimal('remaining_amount', 10, 2)->default(0); // Số tiền còn lại
            $table->enum('deposit_status', ['Paid', 'Pending'])->default('Pending'); // Trạng thái thanh toán cọc
            $table->enum('payment_status', ['Paid', 'Unpaid'])->default('Unpaid'); // Trạng thái thanh toán tổng thể
            $table->enum('status', ['Active', 'Completed', 'Canceled'])->default('Active'); // Trạng thái
            $table->timestamps(); // Thời gian tạo và cập nhật
            
            // Thêm khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('accounts')->onDelete('cascade');

            // Thêm khóa ngoại cho car_id
            $table->foreign('rental_id')->references('rental_id')->on('rental_cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_receipt', function (Blueprint $table) {
            // Xóa khóa ngoại
            $table->dropForeign(['user_id']);
            $table->dropForeign(['rental_id']);
        });
        Schema::dropIfExists('rental_receipt');
        
    }
};
