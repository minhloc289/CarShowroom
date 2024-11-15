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
        Schema::create('car_details', function (Blueprint $table) {
            $table->id('car_id'); // Khóa chính tự động tăng

            // Thông tin chung
            $table->string('brand', 100)->notNullable();
            $table->string('name', 100)->notNullable();
            $table->string('model', 100)->notNullable();
            $table->integer('year')->notNullable();
            $table->string('engine_type', 50)->nullable();
            $table->integer('seat_capacity')->nullable();

            // Thông số kỹ thuật
            $table->string('engine_power', 50)->nullable();
            $table->integer('max_speed')->nullable();
            $table->string('trunk_capacity', 50)->nullable();

            // Kích thước
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();

            // Ảnh
            $table->string('image_url', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_details');
    }
};
