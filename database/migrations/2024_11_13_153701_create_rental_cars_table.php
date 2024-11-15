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
        Schema::create('rental_cars', function (Blueprint $table) {
            $table->id('rental_id'); // Khóa chính tự động tăng
            $table->unsignedBigInteger('car_id'); // car_id mà không có ràng buộc khóa ngoại
            $table->text('license_plate_number')->unique(); // Biển số xe
            $table->decimal('rental_price_per_day', 10, 2)->notNullable(); // Giá thuê mỗi ngày
            $table->enum('availability_status', ['Available', 'Rented'])->default('Available'); // Tình trạng sẵn có
            $table->text('rental_conditions')->nullable(); // Điều kiện thuê
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_cars');
    }
};
