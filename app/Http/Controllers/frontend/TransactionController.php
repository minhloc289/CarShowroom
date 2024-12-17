<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;

class TransactionController extends Controller
{
    //
    public function index()
    {
        $transactions = Payment::with('order.salesCar') // Nạp thêm quan hệ: Order -> SalesCar
            ->orderBy('payment_deposit_date', 'desc') // Sắp xếp theo ngày thanh toán
            ->get();

        return view('frontend.profilepage.transactionHistory', ['transactions' => $transactions]);
    }
    public function orderDetails($orderId)
    {
        $order = Order::with([
            'account',
            'salesCar.carDetails',
            'payments'
        ])->where('order_id', $orderId)->firstOrFail();

        return view('frontend.profilepage.order_details', compact('order'));
    }
}
