<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order; // Import model Order
use App\Models\Payment; // Import model Payment
use App\Models\SalesCars; // Import model SalesCars
use App\Models\Account; 
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function index()
    {
        // Lấy danh sách tất cả các order
        $orders = Order::with(['payments', 'salesCar.carDetails', 'account'])->get();

        return view('Backend.order-management.index', compact('orders'));
    }
    public function detail(Order $order)
    {
        return view('Backend.order-management.order_details', compact('order'));
    }
    public function confirmPayment($order)
    {
        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($order);
        $payment = $order->payments->first();
        

        // Cập nhật trạng thái đơn hàng và thanh toán
        $order->update(['status_order' => 1]); // Cập nhật trạng thái đơn hàng thành Hoàn tất

        // Cập nhật trạng thái trong bảng payments nếu tồn tại
        if ($payment) {
            $payment->update([
                'status_deposit' => 1, // Đã đặt cọc
                'status_payment_all' => 1 // Đã thanh toán toàn phần
            ]);
        }
        toastr()->success('Thanh toán thành công');
        
        return redirect()->back();
    }
}
