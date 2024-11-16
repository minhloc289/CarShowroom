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
        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->id('detail_id'); // Khóa chính tự động tăng
            $table->unsignedBigInteger('invoice_id'); // Khóa ngoại tham chiếu đến bảng sale_invoice
            $table->unsignedBigInteger('car_id')->nullable(); // Khóa ngoại tham chiếu đến bảng car_details, cho phép null
            $table->unsignedBigInteger('accessory_id')->nullable(); // Khóa ngoại tham chiếu đến bảng accessories, cho phép null
            $table->unsignedBigInteger('service_id')->nullable(); // Khóa ngoại tham chiếu đến bảng services, cho phép null
            $table->integer('quantity')->default(1); // Số lượng
            $table->decimal('unit_price', 10, 2); // Đơn giá
            $table->decimal('total_price', 10, 2); // Tổng giá
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('invoice_id')->references('invoice_id')->on('sale_invoice')->onDelete('cascade');
            $table->foreign('car_id')->references('car_id')->on('car_details')->onDelete('set null');
            $table->foreign('accessory_id')->references('accessory_id')->on('accessories')->onDelete('set null');
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_detail', function (Blueprint $table) {
            // Xóa các khóa ngoại
            $table->dropForeign(['invoice_id']);
            $table->dropForeign(['car_id']);
            $table->dropForeign(['accessory_id']);
            $table->dropForeign(['service_id']);
        });

        Schema::dropIfExists('invoice_detail');
    }
};
