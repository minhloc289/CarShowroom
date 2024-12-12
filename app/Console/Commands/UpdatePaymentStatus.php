<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaymentDetails;
use App\Models\Payment;

class UpdatePaymentStatus extends Command
{
    protected $signature = 'payment:update-status';
    protected $description = 'Cập nhật trạng thái thanh toán nếu quá hạn';

    public function handle()
    {
        // Lấy tất cả các bản ghi có status = 0 và đã quá hạn thanh toán
        $payments = Payment::where('status', 0)
            ->whereHas('paymentDetail', function ($query) {
                $query->where('due_date', '<', now());
            })
            ->get();

        foreach ($payments as $payment) {
            $payment->update(['status' => 2]); // Cập nhật thành Hủy
            $this->info("Payment ID {$payment->payment_id} đã được cập nhật thành Hủy (Quá hạn)");
        }

        $this->info("Đã cập nhật trạng thái thanh toán!");
    }
}
