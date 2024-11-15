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
        Schema::create('sales_cars', function (Blueprint $table) {
            $table->id('sale_id'); // Khóa chính tự động tăng
            $table->unsignedBigInteger('car_id'); // car_id mà không có ràng buộc khóa ngoại
            $table->decimal('sale_price', 10, 2)->notNullable(); // Giá bán
            $table->enum('availability_status', ['Available', 'Sold'])->default('Available'); // Tình trạng sẵn có
            $table->integer('warranty_period')->nullable(); // Thời hạn bảo hành (số tháng)
            $table->text('sale_conditions')->nullable(); // Điều kiện bán
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_cars');
    }
};
