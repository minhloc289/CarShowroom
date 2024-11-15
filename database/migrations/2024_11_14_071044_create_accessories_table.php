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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id('accessory_id'); // Khóa chính tự động tăng
            $table->string('name', 100)->notNullable(); // Tên phụ kiện
            $table->decimal('price', 10, 2)->notNullable(); // Giá phụ kiện
            $table->text('description')->nullable(); // Mô tả phụ kiện
            $table->string('image_url', 255)->nullable(); // URL hình ảnh
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories');
    }
};
