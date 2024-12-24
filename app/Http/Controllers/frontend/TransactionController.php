<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\RentalOrder;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function index()
    {
        // Dữ liệu xe bán
        $user = Auth::guard('account')->user();
        $currentUserId=$user->id;
        $transactions = Payment::with([
            'order.salesCar.carDetails', // Nạp quan hệ từ Order -> SalesCar -> CarDetails
            'order.accessories'          // Nạp quan hệ từ Order -> Accessories
        ])
        ->whereHas('order', function ($query) use ($currentUserId) {
            $query->where('account_id', $currentUserId); // Lọc các order của khách hàng đang đăng nhập
        })
        ->orderBy('payment_deposit_date', 'desc') // Sắp xếp theo ngày thanh toán
        ->get();

        // Dữ liệu xe thuê
        $rentalTransactions = RentalOrder::with('rentalCar.carDetails') // Nạp quan hệ: RentalOrder -> RentalCar
            ->where('user_id', $currentUserId) // Lọc các rental order của khách hàng đang đăng nhập
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
