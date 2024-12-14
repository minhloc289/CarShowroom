<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Payment;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('payment:check-status', function () {
    // Cập nhật trạng thái status_deposit
    $this->info("Đang kiểm tra trạng thái status_deposit...");
    Payment::where('status_deposit', 0)
        ->where('deposit_deadline', '<', now())
        ->update(['status_deposit' => 2]);
    $this->info("Hoàn thành cập nhật trạng thái status_deposit!");

    // Cập nhật trạng thái status_payment_all
    $this->info("Đang kiểm tra trạng thái status_payment_all...");
    Payment::where('status_payment_all', 0)
        ->where('payment_deadline', '<', now())
        ->update(['status_payment_all' => 2]);
    $this->info("Hoàn thành cập nhật trạng thái status_payment_all!");

})->purpose('Check and update payment statuses daily');