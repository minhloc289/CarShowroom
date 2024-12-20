<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('accessory_id')->nullable(); // Thêm cột accessory_id
            $table->foreign('accessory_id')->references('accessory_id')->on('accessories')->onDelete('cascade'); // Thiết lập khóa ngoại
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['accessory_id']);
            $table->dropColumn('accessory_id');
        });
    }
};
