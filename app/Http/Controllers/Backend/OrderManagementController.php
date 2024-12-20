<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order; // Import model Order
use App\Models\Payment; // Import model Payment
use App\Models\SalesCars; // Import model SalesCars
use App\Models\Account; 
use App\Models\CarDetails; 
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
    public function addCar()
    {
        // Lấy danh sách xe chưa bị xóa từ bảng car_details liên kết với bảng sales_cars
        $cars = CarDetails::whereHas('salesCars', function ($query) {
            $query->where('is_deleted', 0);
        })->with('sale')->get();
    
        // Nhóm xe theo thương hiệu
        $carsByBrand = $cars->groupBy('brand');
    
        // Lấy danh sách tất cả tài khoản khách hàng
        $accounts = Account::select('id', 'name', 'email', 'phone', 'address')->get();
    
        // Trả về view với dữ liệu xe và tài khoản
        return view('Backend.order-management.order_car_add', compact('cars', 'carsByBrand', 'accounts'));
    }
    
    public function storeOrder(Request $request)
    {

        // Validate dữ liệu từ form
        $request->validate([
            'customer_phone' => 'required|string',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_address' => 'required|string',
            'selected_car' => 'required|exists:sales_cars,car_id',
            'payment_method' => 'required|in:full,deposit',
            'total_price' => 'required|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
        ]);
        // Tìm khách hàng theo số điện thoại
        $account = Account::firstOrCreate([
            'phone' => $request->customer_phone
        ], [
            'name' => $request->customer_name,
            'email' => $request->customer_email,
            'address' => $request->customer_address,
        ]);
    
        // Kiểm tra nếu xe đã tồn tại trong đơn hàng khác
    
        // Tạo một đơn hàng mới
        $order = Order::create([
            'account_id' => $account->id,
            'sale_id' => $request->selected_car,
            'status_order' => $request->payment_method === 'full' ? 1 : 0, // Hoàn tất nếu thanh toán toàn bộ
            'order_date' => now()->toDateString(),
        ]);
    
        // Tạo payment mới
        $paymentData = [
            'order_id' => $order->order_id,
            'total_amount' => $request->total_price,
            'payment_deposit_date' => now(),
            'status_deposit' => 0, // Mặc định đang chờ đặt cọc
            'status_payment_all' => 0, // Mặc định chưa thanh toán
            'deposit_deadline' => now()->addDays(1), // Hạn đặt cọc là 7 ngày
            'payment_deadline' => now()->addDays(30), // Hạn thanh toán toàn bộ là 30 ngày
        ];
    
        if ($request->payment_method === 'full') {
            $paymentData['status_deposit'] = 1; // Đã đặt cọc
            $paymentData['status_payment_all'] = 1; // Đã thanh toán toàn bộ
            $paymentData['deposit_amount'] = $request->total_price; // Toàn bộ giá trị đơn hàng
            $paymentData['remaining_amount'] = 0; // Không còn nợ
            $order->update(['status_order' => 1]); // Cập nhật trạng thái đơn hàng là hoàn tất
        } elseif ($request->payment_method === 'deposit') {
            $paymentData['status_deposit'] = 1; // Đã đặt cọc
            $paymentData['status_payment_all'] = 0; // Chưa thanh toán toàn bộ
            $paymentData['deposit_amount'] = $request->deposit_amount;
            $paymentData['remaining_amount'] = $request->remaining_amount;
        }
    
        Payment::create($paymentData);
    
        // Điều hướng về trang danh sách đơn hàng với thông báo thành công
        toastr()->success('Thêm đơn hàng thành công');
        return redirect()->route('orders.index');
    }
    

}
