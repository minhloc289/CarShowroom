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
        Schema::create('schedule_booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->dateTime('preferred_date')->notNullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();

            // Thêm khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('account')->onDelete('cascade');
            // Thêm khóa ngoại cho service_id
            $table->foreign('service_id')->references('service_id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_booking', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa bảng
            $table->dropForeign(['user_id']);
            $table->dropForeign(['service_id']);
        }); 

        Schema::dropIfExists('schedule_booking');
    }
};
