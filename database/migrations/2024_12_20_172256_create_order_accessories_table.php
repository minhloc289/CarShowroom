<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_accessories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id'); // Liên kết với bảng orders
            $table->unsignedBigInteger('accessory_id'); // Liên kết với bảng accessories
            $table->integer('quantity')->default(1); // Số lượng phụ kiện
            $table->decimal('price', 10, 2); // Giá phụ kiện
            $table->timestamps(); // created_at và updated_at

            // Ràng buộc khóa ngoại
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('accessory_id')->references('accessory_id')->on('accessories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_accessories');
    }
};
