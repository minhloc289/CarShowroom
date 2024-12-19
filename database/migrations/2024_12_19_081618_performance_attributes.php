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
        Schema::table('car_details', function (Blueprint $table) {
            $table->decimal('acceleration_time', 5, 2)->nullable()->after('height'); // Thời gian tăng tốc (0-100 km/h)
            $table->decimal('fuel_efficiency', 5, 2)->nullable()->after('acceleration_time'); // Tiêu hao nhiên liệu (L/100km)
            $table->integer('torque')->nullable()->after('fuel_efficiency'); // Mô-men xoắn (Nm)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_details', function (Blueprint $table) {
            $table->dropColumn(['acceleration_time', 'fuel_efficiency', 'torque']);
        });
    }
};
