<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Payment;
use App\Models\Order;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('rental:expire-payments', function () {
    $this->comment('Expired payments');
})->purpose('Expire payments');
Schedule::command('rental:expire-payments')->everyFiveMinutes();
Schedule::command('payment:check-status')->everyFiveMinutes();

Artisan::command('payment:check-status', function () {
    // Cập nhật trạng thái status_deposit và status_order
    $this->info("Đang kiểm tra trạng thái status_deposit và cập nhật status_order...");
    Payment::where('status_deposit', 0)
        ->where('deposit_deadline', '<', now())
        ->get()
        ->each(function ($payment) {
            $payment->update(['status_deposit' => 2]);
            if ($payment->order) {
                $payment->order->update(['status_order' => 2]);
            }
        });
    $this->info("Hoàn thành cập nhật trạng thái status_deposit và status_order!");

    // Cập nhật trạng thái status_payment_all và status_order
    $this->info("Đang kiểm tra trạng thái status_payment_all và cập nhật status_order...");
    Payment::where('status_payment_all', 0)
        ->where('payment_deadline', '<', now())
        ->get()
        ->each(function ($payment) {
            $payment->update(['status_payment_all' => 2]);
            if ($payment->order) {
                $payment->order->update(['status_order' => 2]);
            }
        });
    $this->info("Hoàn thành cập nhật trạng thái status_payment_all và status_order!");
})->purpose('Check and update payment statuses and orders daily');


