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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // Khóa chính tự động tăng
            $table->string('account_id', 6); // ID tài khoản từ bảng accounts
            $table->unsignedBigInteger('payment_detail_id'); // ID chi tiết thanh toán
            $table->unsignedTinyInteger('status')->default(0); // 0: Pending, 1: Paid, 2: Cancelled
            $table->string('transaction_code')->nullable(); // Mã giao dịch
            $table->decimal('total_amount', 15, 2)->nullable(); // Tổng tiền giao dịch
            $table->timestamps(); // Thời gian tạo và cập nhật
            // Ràng buộc khóa ngoại
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('payment_detail_id')->references('payment_details_id')->on('payment_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa khóa ngoại trước khi xóa bảng
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['payment_detail_id']);
        });

        // Xóa bảng
        Schema::dropIfExists('payments');
    }
};
