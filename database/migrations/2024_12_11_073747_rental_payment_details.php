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
        Schema::create('rental_payment_details', function (Blueprint $table) {
            $table->id('rental_payment_details_id'); // Khóa chính tự tăng
            $table->unsignedBigInteger('payment_id'); // Liên kết với bảng rental_payment
            $table->date('date'); // Ngày thanh toán
            $table->decimal('deposit_amount', 15, 2); // Số tiền thanh toán trong giao dịch này
            $table->decimal('remaining_amount', 15, 2)->nullable(); // Số tiền còn lại sau giao dịch
            $table->date('due_date')->nullable(); // Hạn chót thanh toán nếu có
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('payment_id')->references('payment_id')->on('rental_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_payment_details', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });

        Schema::dropIfExists('rental_payment_details');
    }
};
