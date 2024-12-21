<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_customers', function (Blueprint $table) {
            $table->id('rental_id'); // Khóa chính
            $table->unsignedBigInteger('car_id'); // Khóa ngoại
            $table->string('customer_name'); // Tên khách hàng
            $table->string('phone_number'); // Số điện thoại
            $table->string('email'); // Email
            $table->date('test_drive_date'); // Ngày lái thử
            $table->text('other_request')->nullable(); // Other request (có thể rỗng)
            $table->timestamps();

            // Định nghĩa khóa ngoại
            $table->foreign('car_id')->references('car_id')->on('car_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_customers');
    }
}
