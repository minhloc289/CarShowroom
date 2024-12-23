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
            $table->boolean('is_renewal')->default(false)->after('status'); // Thêm cột is_renewal với giá trị mặc định là false
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_receipt', function (Blueprint $table) {
            $table->dropColumn('is_renewal');
        });
    }
};
