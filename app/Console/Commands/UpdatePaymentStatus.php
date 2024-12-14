<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;

class UpdatePaymentStatus extends Command
{
    protected $signature = 'payment:update-status';
    protected $description = 'Cập nhật trạng thái thanh toán nếu quá hạn';

    public function handle()
    {
        // Cập nhật trạng thái status_deposit
        $this->updateStatusDeposit();

        // Cập nhật trạng thái status_payment_all
        $this->updateStatusPaymentAll();

        $this->info("Hoàn thành cập nhật trạng thái thanh toán!");
    }

    private function updateStatusDeposit()
    {
        // Lấy các payment có status_deposit = 0 và quá hạn
        $payments = Payment::where('status_deposit', 0)
            ->where('deposit_deadline', '<', now())
            ->get();

        foreach ($payments as $payment) {
            $payment->update(['status_deposit' => 2]); // Cập nhật status_deposit thành Hủy
            $this->info("Payment ID {$payment->payment_id}: status_deposit đã được cập nhật thành Hủy (Quá hạn)");
        }
    }

    private function updateStatusPaymentAll()
    {
        // Lấy các payment có status_payment_all = 0 và quá hạn
        $payments = Payment::where('status_payment_all', 0)
            ->where('payment_deadline', '<', now())
            ->get();

        foreach ($payments as $payment) {
            $payment->update(['status_payment_all' => 2]); // Cập nhật status_payment_all thành Hủy
            $this->info("Payment ID {$payment->payment_id}: status_payment_all đã được cập nhật thành Hủy (Quá hạn)");
        }
    }
}
