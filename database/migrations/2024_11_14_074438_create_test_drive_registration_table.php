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
        Schema::create('test_drive_registration', function (Blueprint $table) {
            $table->id('registration_id');
            $table->string('user_id'); // user_id với kiểu string để phù hợp với id trong bảng accounts
            $table->unsignedBigInteger('car_id');
            $table->dateTime('preferred_date')->notNullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();

            // Thêm khóa ngoại cho user_id
            $table->foreign('user_id')->references('id')->on('accounts')->onDelete('cascade');
            // Thêm khóa ngoại cho car_id
            $table->foreign('car_id')->references('car_id')->on('car_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_drive_registration', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa bảng
            $table->dropForeign(['user_id']);
            $table->dropForeign(['car_id']);
        });

        Schema::dropIfExists('test_drive_registration');
    }
};
