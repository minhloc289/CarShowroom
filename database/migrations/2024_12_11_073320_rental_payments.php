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
            $table->id('payment_id'); // Khóa chính
            $table->string('account_id', 6); // ID tài khoản từ bảng accounts
            $table->unsignedBigInteger('receipt_id'); // Liên kết với bảng rental_receipt
            $table->unsignedTinyInteger('status')->default(0); // 0: Pending, 1: Paid, 2: Cancelled
            $table->string('transaction_code')->nullable(); // Mã giao dịch
            $table->decimal('total_amount', 15, 2)->nullable(); // Tổng tiền thanh toán
            $table->timestamps();
    
            // Khóa ngoại
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('receipt_id')->references('receipt_id')->on('rental_receipt')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_payments', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['receipt_id']);
        });

        Schema::dropIfExists('rental_payments');
    }
};
