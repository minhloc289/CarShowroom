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
        // Thêm khóa ngoại từ bảng rental_cars đến car_details
        Schema::table('rental_cars', function (Blueprint $table) {
            $table->foreign('car_id')->references('car_id')->on('car_details')->onDelete('cascade');
        });

        // Thêm khóa ngoại từ bảng sales_cars đến car_details
        Schema::table('sales_cars', function (Blueprint $table) {
            $table->foreign('car_id')->references('car_id')->on('car_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa khóa ngoại từ bảng rental_cars
        Schema::table('rental_cars', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
        });

        // Xóa khóa ngoại từ bảng sales_cars
        Schema::table('sales_cars', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
        });
    }
};
