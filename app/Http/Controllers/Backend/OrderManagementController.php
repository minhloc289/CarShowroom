<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order; // Import model Order
use App\Models\Payment; // Import model Payment
use App\Models\SalesCars; // Import model SalesCars
use App\Models\Account;
use App\Models\Accessories;
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
                'status_payment_all' => 1, // Đã thanh toán toàn phần
                'remaining_payment_date' => now()
            ]);
        }
        toastr()->success('Thanh toán thành công');

        return redirect()->back();
    }
    public function addCar()
    {
        // Lấy danh sách xe chưa bị xóa từ bảng car_details liên kết với bảng sales_cars
        $cars = CarDetails::whereHas('salesCars', function ($query) {
            $query->where('is_deleted', 0)
                  ->where('quantity', '>', 0);
        })->with('salesCars')->get();
        ;
        $accessories = Accessories::where('quantity', '>', 0)
                          ->where('is_deleted', 0)
                          ->get();


        // Nhóm xe theo thương hiệu
        $carsByBrand = $cars->groupBy('brand');

        // Lấy danh sách tất cả tài khoản khách hàng
        $accounts = Account::select('id', 'name', 'email', 'phone', 'address')->get();

        // Trả về view với dữ liệu xe và tài khoản
        return view('Backend.order-management.order_car_add', compact('cars', 'carsByBrand', 'accounts', 'accessories'));
    }

    // public function storeOrder(Request $request)
    // {

    //     // Validate dữ liệu từ form
    //     $request->validate([
    //         'customer_phone' => 'required|string',
    //         'customer_name' => 'required|string',
    //         'customer_email' => 'required|email',
    //         'customer_address' => 'required|string',
    //         'selected_car' => 'required|exists:sales_cars,car_id',
    //         'payment_method' => 'required|in:full,deposit',
    //         'total_price' => 'required|numeric|min:0',
    //         'deposit_amount' => 'nullable|numeric|min:0',
    //         'remaining_amount' => 'nullable|numeric|min:0',
    //     ]);
    //     // Tìm khách hàng theo số điện thoại
    //     $account = Account::firstOrCreate([
    //         'phone' => $request->customer_phone
    //     ], [
    //         'name' => $request->customer_name,
    //         'email' => $request->customer_email,
    //         'address' => $request->customer_address,
    //     ]);

    //     // Kiểm tra nếu xe đã tồn tại trong đơn hàng khác

    //     // Tạo một đơn hàng mới
    //     $order = Order::create([
    //         'account_id' => $account->id,
    //         'sale_id' => $request->selected_car,
    //         'status_order' => $request->payment_method === 'full' ? 1 : 0, // Hoàn tất nếu thanh toán toàn bộ
    //         'order_date' => now()->toDateString(),
    //     ]);

    //     // Tạo payment mới
    //     $paymentData = [
    //         'order_id' => $order->order_id,
    //         'total_amount' => $request->total_price,
    //         'payment_deposit_date' => now(),
    //         'status_deposit' => 0, // Mặc định đang chờ đặt cọc
    //         'status_payment_all' => 0, // Mặc định chưa thanh toán
    //         'deposit_deadline' => now()->addDays(1), // Hạn đặt cọc là 7 ngày
    //         'payment_deadline' => now()->addDays(30), // Hạn thanh toán toàn bộ là 30 ngày
    //     ];

    //     if ($request->payment_method === 'full') {
    //         $paymentData['status_deposit'] = 1; // Đã đặt cọc
    //         $paymentData['status_payment_all'] = 1; // Đã thanh toán toàn bộ
    //         $paymentData['deposit_amount'] = $request->total_price; // Toàn bộ giá trị đơn hàng
    //         $paymentData['remaining_amount'] = 0; // Không còn nợ
    //         $order->update(['status_order' => 1]); // Cập nhật trạng thái đơn hàng là hoàn tất
    //     } elseif ($request->payment_method === 'deposit') {
    //         $paymentData['status_deposit'] = 1; // Đã đặt cọc
    //         $paymentData['status_payment_all'] = 0; // Chưa thanh toán toàn bộ
    //         $paymentData['deposit_amount'] = $request->deposit_amount;
    //         $paymentData['remaining_amount'] = $request->remaining_amount;
    //     }

    //     Payment::create($paymentData);

    //     // Điều hướng về trang danh sách đơn hàng với thông báo thành công
    //     toastr()->success('Thêm đơn hàng thành công');
    //     return redirect()->route('orders.index');
    // }

    public function store(Request $request)
    {
        // Xóa phần tử có index 0 trong selected_accessories nếu tồn tại
        if ($request->has('selected_accessories') && is_array($request->input('selected_accessories'))) {
            $selectedAccessories = $request->input('selected_accessories');
            unset($selectedAccessories[0]); // Xóa phần tử với index 0
            $selectedAccessories = array_values($selectedAccessories); // Sắp xếp lại index của mảng

            // Cập nhật lại dữ liệu trong request
            $request->merge(['selected_accessories' => $selectedAccessories]);
        }

        // Tiến hành validate dữ liệu
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id', // Kiểm tra account_id hợp lệ
            'customer_phone' => 'required',
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'selected_car' => 'nullable|string|exists:sales_cars,sale_id',
            'selected_accessories' => 'nullable|array',
            'payment_method' => 'required|in:full,deposit', // Kiểm tra phương thức thanh toán
        ]);

        // Tính tổng giá trị đơn hàng
        $totalAmount = 0;
        $carPrice = 0;

        // Giá xe
        $saleId = $request->selected_car ? $request->selected_car : null;
        if ($saleId) {
            $car = SalesCars::find($saleId);
            $carPrice = $car->sale_price;
            $totalAmount += $carPrice;
            $car->quantity -= 1;
            $car->save();
        }

        // Giá phụ kiện
        $accessoriesTotal = 0;
        $accessoriesToAttach = [];
        if ($request->has('selected_accessories') && !empty($request->selected_accessories)) {
            foreach ($request->selected_accessories as $accessoryData) {
                $accessory = Accessories::find($accessoryData['accessory_id']);
                $accessoryCost = $accessory->price * $accessoryData['quantity'];
                $accessoriesTotal += $accessoryCost;
                $totalAmount += $accessoryCost;

                // Chuẩn bị dữ liệu để thêm vào bảng trung gian
                $accessoriesToAttach[$accessoryData['accessory_id']] = [
                    'quantity' => $accessoryData['quantity'],
                    'price' => $accessory->price,
                ];
                $accessory->quantity -= $accessoryData['quantity'];
                $accessory->save();
            }
        }

        // Tạo đơn hàng
        $order = Order::create([
            'account_id' => $validated['account_id'],
            'sale_id' => $saleId,
            'status_order' => $request->payment_method === 'full' ? 1 : 0, // Đã thanh toán nếu phương thức là full
            'order_date' => now(),
        ]);

        // Lưu phụ kiện nếu có
        if (!empty($accessoriesToAttach)) {
            $order->accessories()->attach($accessoriesToAttach);
        }

        // Tạo bản ghi trong bảng payments
        $depositAmount = $request->payment_method === 'full'
            ? $totalAmount
            : ($carPrice * 0.15) + $accessoriesTotal; // 15% giá xe + giá trị phụ kiện
        $remainingAmount = $totalAmount - $depositAmount;

        Payment::create([
            'order_id' => $order->order_id,
            'status_deposit' => $request->payment_method === 'full' || $request->payment_method === 'deposit' ? 1 : 0, // Đặt cọc thành công nếu full hoặc deposit
            'status_payment_all' => $request->payment_method === 'full' ? 1 : 0, // Thanh toán toàn bộ nếu full
            'deposit_amount' => $depositAmount,
            'total_amount' => $totalAmount,
            'remaining_amount' => $remainingAmount,
            'deposit_deadline' => $request->payment_method === 'full' ? now() : now()->addDays(7),
            'payment_deadline' => $request->payment_method === 'full' ? now() : now()->addDays(30),
            'full_payment_date' => $request->payment_method === 'full' ? now() : null, // Ngày thanh toán đầy đủ nếu phương thức là full
            'payment_deposit_date' => $request->payment_method === 'deposit' ? now() : null, // Ngày thanh toán còn lại nếu phương thức là deposit
        ]);

        toastr()->success('Thêm đơn hàng thành công');
        return redirect()->back();
    }





}
