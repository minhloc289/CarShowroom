<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment; // Import model Payment
use App\Models\RentalPayment; // Import model Payment
use App\Models\RentalOrder; // Import model Payment
use App\Models\Order; // Import model Payment

use Illuminate\Http\Request;


class RevenueController extends Controller
{
    public function index()
    {
        // Lấy tất cả thanh toán, bỏ qua các đơn hàng có status_order = 0 hoặc 2
        $payments = Payment::with(['order.account', 'order.salesCar.carDetails', 'order.accessories'])
        ->where('status_deposit', 1) // Chỉ lấy các thanh toán có status_deposit = 1
        ->get();
        $rentalPayments = RentalPayment::with(['rentalOrder.user', 'rentalOrder.rentalCar'])
        ->where('full_payment_status', 'Successful') // Chỉ lấy các thanh toán đã hoàn tất
        ->get();
        // Trả về view danh sách thanh toán
        return view('Backend.RevenueandStatistics.Revenueindex', compact('payments','rentalPayments'));
    }
    public function Paymentdetail(Payment $payment)
    {

        return view('Backend.RevenueandStatistics.RevenueDetails', compact('payment'));
    }
    
    public function show($order_id)
    {
        $order = RentalOrder::with(['user', 'rentalCar.carDetails', 'rentalReceipts.rentalCar'])->findOrFail($order_id);

        return view('Backend.RevenueandStatistics.RevenueRentalDetail', compact('order'));
    }
    public function statis_index()
    {
        // Doanh thu từ Payment
        $paymentRevenues = Payment::selectRaw('MONTH(COALESCE(full_payment_date, remaining_payment_date, payment_deposit_date)) as month, SUM(total_amount) as total')
            ->whereYear('full_payment_date', date('Y'))
            ->orWhereYear('remaining_payment_date', date('Y'))
            ->orWhereYear('payment_deposit_date', date('Y'))
            ->groupByRaw('MONTH(COALESCE(full_payment_date, remaining_payment_date, payment_deposit_date))')
            ->pluck('total', 'month');
    
        // Doanh thu từ RentalPayment
        $rentalRevenues = RentalPayment::selectRaw('MONTH(payment_date) as month, SUM(total_amount) as total')
            ->whereYear('payment_date', date('Y'))
            ->groupByRaw('MONTH(payment_date)')
            ->pluck('total', 'month');
    
        // Gộp doanh thu từ cả hai nguồn
        $monthlyRevenues = [];
        for ($i = 1; $i <= 12; $i++) {
            $paymentRevenue = $paymentRevenues[$i] ?? 0;
            $rentalRevenue = $rentalRevenues[$i] ?? 0;
            $monthlyRevenues[$i] = $paymentRevenue + $rentalRevenue;
        }
    
        return view('Backend.RevenueandStatistics.statisindex', [
            'monthlyRevenues' => array_values($monthlyRevenues),
        ]);
    }
    
    
}
