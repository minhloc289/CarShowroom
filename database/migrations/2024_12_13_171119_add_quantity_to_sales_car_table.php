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
        Schema::table('sales_cars', function (Blueprint $table) {
            $table->integer('quantity')->nullable();  // Thêm cột quantity với giá trị mặc định là 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_car', function (Blueprint $table) {
            $table->dropColumn('quantity');  // Xóa cột quantity nếu rollback migration
        });
    }
};
