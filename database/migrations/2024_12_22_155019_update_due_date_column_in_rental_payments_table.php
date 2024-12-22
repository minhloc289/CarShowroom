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
        Schema::table('rental_payments', function (Blueprint $table) {
            // Thay đổi kiểu dữ liệu của cột due_date từ DATE sang DATETIME
            $table->dateTime('due_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('rental_payments', function (Blueprint $table) {
            // Khôi phục lại kiểu dữ liệu của cột due_date về DATE
            $table->date('due_date')->change();
        });
    }
};
