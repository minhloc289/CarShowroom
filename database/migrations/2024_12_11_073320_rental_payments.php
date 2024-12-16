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
        Schema::create('rental_payments', function (Blueprint $table) {
            $table->id('payment_id'); // Khóa chính tự động tăng
            $table->unsignedBigInteger('order_id'); // Liên kết với đơn hàng
            $table->enum('status_deposit', ['Pending', 'Successful', 'Canceled'])->default('Pending')->nullable(); // Trạng thái thanh toán cọc (nullable)
            $table->enum('full_payment_status', ['Pending', 'Successful', 'Canceled'])->default('Pending'); // Trạng thái thanh toán toàn bộ
            $table->decimal('deposit_amount', 10, 2)->nullable(); // Số tiền cọc (nullable)
            $table->decimal('total_amount', 10, 2); // Tổng số tiền thanh toán
            $table->decimal('remaining_amount', 10, 2); // Số tiền còn lại
            $table->date('due_date'); // Ngày đến hạn thanh toán
            $table->timestamp('payment_date')->nullable(); // Ngày thanh toán
            $table->string('transaction_code', 255); // Mã giao dịch
            $table->timestamps();

            // Khóa ngoại cho order_id
            $table->foreign('order_id')->references('order_id')->on('rental_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_payments', function (Blueprint $table) {
            // Xóa khóa ngoại
            $table->dropForeign(['order_id']); 
        });

        Schema::dropIfExists('rental_payments');
    }
};
