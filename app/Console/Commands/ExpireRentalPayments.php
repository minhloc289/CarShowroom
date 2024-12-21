<?php

namespace App\Console\Commands;

use App\Http\Controllers\frontend\RentalPaymentController;
use Illuminate\Console\Command;
use App\Models\RentalPayment;
use App\Models\RentalOrder;
use App\Models\RentalReceipt;
use App\Models\RentalCars;

class ExpireRentalPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rental:expire-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và hủy các giao dịch quá hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Logic xử lý của bạn ở đây
        $payments = RentalPayment::where('due_date', '<', now())
            ->where('status_deposit', 'Pending')
            ->get();

        foreach ($payments as $payment) {
            $payment->update([
                'status_deposit' => 'Canceled',
                'full_payment_status' => 'Canceled',
            ]);

            $order = RentalOrder::find($payment->order_id);
            if ($order) {
                $order->update(['status' => 'Canceled']);
                $rental_car = RentalCars::find($order->rental_id);
                if ($rental_car && $rental_car->availability_status === 'Rented') {
                    $rental_car->update(['availability_status' => 'Available']);
                }
            }

            $receipt = RentalReceipt::where('order_id', $payment->order_id)->first();
            if ($receipt) {
                $receipt->update(['status' => 'Canceled']);
            }
        }

        $this->info('Đã kiểm tra và xử lý các giao dịch quá hạn.');
    }
}
