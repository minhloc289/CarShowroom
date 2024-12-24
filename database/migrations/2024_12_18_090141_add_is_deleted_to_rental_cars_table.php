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
        Schema::table('rental_cars', function (Blueprint $table) {
            $table->boolean('is_deleted')->default(false)->after('rental_conditions'); // Thêm cột is_deleted với mặc định là false
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_cars', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }
};
