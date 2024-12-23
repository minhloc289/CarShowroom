<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment; // Import model Payment
use App\Models\Order; // Import model Payment

use Illuminate\Http\Request;


class RevenueController extends Controller
{
    public function index()
    {
        // Lấy tất cả thanh toán, bỏ qua các đơn hàng có status_order = 0 hoặc 2
        $payments = Payment::with(['order.account', 'order.salesCar.carDetails', 'order.accessories'])
            ->whereHas('order', function ($query) {
                $query->whereNotIn('status_order', [0, 2]);
            })
            ->get();

        // Trả về view danh sách thanh toán
        return view('Backend.RevenueandStatistics.Revenueindex', compact('payments'));
    }
    public function Paymentdetail(Payment $payment)
    {

        return view('Backend.RevenueandStatistics.RevenueDetails', compact('payment'));
    }

}
