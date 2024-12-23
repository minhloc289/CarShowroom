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
        Schema::table('rental_receipt', function (Blueprint $table) {
            // Chuyển kiểu dữ liệu của rental_end_date từ DATE sang DATETIME
            $table->dateTime('rental_end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_receipt', function (Blueprint $table) {
            // Khôi phục lại kiểu dữ liệu của rental_end_date về DATE
            $table->date('rental_end_date')->change();
        });
    }
};
