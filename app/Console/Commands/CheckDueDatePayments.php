<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RentalPayment;
use App\Models\RentalOrder;
use App\Models\RentalReceipt;
use App\Models\RentalCars;
use Carbon\Carbon;

class CheckDueDatePayments extends Command
{
    protected $signature = 'payments:check-due-date';

    protected $description = 'Kiểm tra các đơn hàng đến hạn mà chưa thanh toán đầy đủ để hủy trạng thái';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy tất cả các giao dịch đến hạn mà chưa thanh toán đầy đủ
        $payments = RentalPayment::where('due_date', '<', now())
            ->where('full_payment_status', 'Pending')
            ->get();

        foreach ($payments as $payment) {
            // Cập nhật trạng thái của thanh toán
            $payment->update([
                'status_deposit' => 'Canceled',
                'full_payment_status' => 'Canceled',
            ]);

            // Cập nhật trạng thái của đơn hàng
            $order = RentalOrder::find($payment->order_id);
            if ($order && $order->status === 'Deposit Paid') {
                $order->update(['status' => 'Canceled']);

                // Cập nhật trạng thái xe từ Rented -> Available
                $rentalCar = RentalCars::find($order->rental_id);
                if ($rentalCar && $rentalCar->availability_status === 'Rented') {
                    $rentalCar->update(['availability_status' => 'Available']);
                }

                // Cập nhật trạng thái của hóa đơn thuê xe
                $receipt = RentalReceipt::where('order_id', $payment->order_id)->first();
                if ($receipt) {
                    $receipt->update(['status' => 'Canceled']);
                }
            }
        }

        $this->info('Đã kiểm tra và xử lý các đơn hàng đến hạn.');
    }
}
