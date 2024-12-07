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
        Schema::create('accounts', function (Blueprint $table) {
            // Cột ID định dạng 'ACC' + số tự động tăng
            $table->string('id',6)->primary(); // Định nghĩa khóa chính với định dạng tuỳ chỉnh
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
