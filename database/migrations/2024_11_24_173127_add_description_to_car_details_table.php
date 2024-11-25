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
        Schema::table('car_details', function (Blueprint $table) {
            $table->text('description')->nullable()->after('height');
 // Replace 'existing_column' with a column already present
        });
    }
    
    public function down()
    {
        Schema::table('car_details', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
    
};
