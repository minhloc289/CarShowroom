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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id('payment_details_id'); // Khóa chính tự động tăng
            $table->date('date');
            $table->unsignedBigInteger('sale_id');
            $table->decimal('deposit_amount', 15, 2);
            $table->decimal('remaining_amount', 15, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        
            // Ràng buộc khóa ngoại
            $table->foreign('sale_id')->references('sale_id')->on('sales_cars')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_details', function (Blueprint $table){
            $table->dropForeign(['sale_id']);
        });
        Schema::dropIfExists('payment_details');
    }
};
