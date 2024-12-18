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
        Schema::table('sales_cars', function (Blueprint $table) {
            $table->boolean('is_deleted')->default(false)->after('updated_at')->comment('Indicates if the car is deleted');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('sales_cars', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }
};
