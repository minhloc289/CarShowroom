<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\RentalOrder;

class TransactionController extends Controller
{
    //
    public function index()
    {
        // Dữ liệu xe bán
        $transactions = Payment::with([
            'order.salesCar.carDetails', // Nạp quan hệ từ Order -> SalesCar -> CarDetails để lấy thông tin xe
            'order.accessories'          // Nạp quan hệ từ Order -> Accessories để lấy thông tin phụ kiện
        ])
            ->orderBy('payment_deposit_date', 'desc') // Sắp xếp theo ngày thanh toán
            ->get();
        // Dữ liệu xe thuê
        $rentalTransactions = RentalOrder::with('rentalCar.carDetails') // Nạp thêm quan hệ: RentalOrder -> RentalCar
            ->orderBy('order_date', 'desc') // Sắp xếp theo ngày tạo đơn
            ->get();

        return view('frontend.profilepage.transactionHistory', [
            'transactions' => $transactions, // Xe bán
            'rentalTransactions' => $rentalTransactions, // Xe thuê
        ]);
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

    public function rentalOrderDetails($orderId)
    {
        $rentalOrder = RentalOrder::with([
            'user',
            'rentalCar.carDetails',
            'rentalPayments'
        ])->where('order_id', $orderId)->firstOrFail();

        return view('frontend.profilepage.rentalDetails', compact('rentalOrder'));
    }

    public function getStatus($orderId)
    {
        $rentalOrder = RentalOrder::findOrFail($orderId);
        return response()->json(['status' => $rentalOrder->status]);
    }


}
