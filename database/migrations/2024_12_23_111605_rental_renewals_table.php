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
        Schema::create('rental_renewals', function (Blueprint $table) {
            $table->id('renewal_id'); // Khóa chính tự động tăng
            $table->unsignedBigInteger('receipt_id'); // Liên kết với rental_receipt
            $table->dateTime('request_date'); // Ngày yêu cầu gia hạn
            $table->dateTime('new_end_date'); // Ngày kết thúc mới sau gia hạn
            $table->decimal('renewal_cost', 10, 2); // Chi phí gia hạn
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); // Trạng thái gia hạn
            $table->timestamps(); // Thời gian tạo và cập nhật
        
            // Khóa ngoại
            $table->foreign('receipt_id')->references('receipt_id')->on('rental_receipt')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_renewals', function (Blueprint $table) {
            $table->dropForeign(['receipt_id']);
        });
        Schema::dropIfExists('rental_renewals');
    }
};
