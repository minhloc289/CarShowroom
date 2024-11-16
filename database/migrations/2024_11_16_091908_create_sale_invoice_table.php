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
        Schema::create('sale_invoice', function (Blueprint $table) {
            $table->id('invoice_id'); // Khóa chính tự động tăng
            $table->string('user_id'); // Khóa ngoại đến bảng accounts
            $table->unsignedBigInteger('seller_id'); // Khóa ngoại đến bảng users
            $table->dateTime('invoice_date')->notNullable(); // Ngày xuất hóa đơn
            $table->decimal('total_amount', 10, 2)->notNullable(); // Tổng số tiền
            $table->enum('payment_status', ['Pending', 'Paid', 'Overdue'])->default('Pending'); // Trạng thái thanh toán
            $table->timestamps(); // Thời gian tạo và cập nhật

            // Thêm khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('accounts')->onDelete('cascade');
            // Thêm khóa ngoại cho seller_id
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('sale_invoice', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa bảng
            $table->dropForeign(['user_id']);
            $table->dropForeign(['seller_id']);
        });
        Schema::dropIfExists('sale_invoice');
    }
};
