<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalOrder;
use App\Models\RentalCars;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\DepositSuccessfulNotification;
use App\Mail\FullPaymentConfirmationMail;
use App\Models\RentalReceipt;
use App\Models\RentalPayment;

class RentalOrderController extends Controller
{
    public function index() 
    {
        $orders = RentalOrder::with(['user', 'rentalCar.carDetails'])->paginate(10); // Eager loading for related data
        return view('Backend.rentalOrder.rentalOrderIndex', compact('orders'));
    }

    public function filter(Request $request)
    {
        $query = RentalOrder::with(['user', 'rentalCar.carDetails']);

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $query->where('order_id', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        // Trả về JSON
        return response()->json(['orders' => $orders]);
    }

    public function show($order_id)
    {
        $order = RentalOrder::with(['user', 'rentalCar.carDetails', 'rentalReceipts.rentalCar'])->findOrFail($order_id);

        return view('Backend.rentalOrder.viewRentalOrder', compact('order'));
    }

    public function loadCreateForm()
    {
        // Lấy danh sách xe thuê có sẵn (trạng thái 'Available')
        $rentalCars = RentalCars::where('availability_status', 'Available')
        ->with('carDetails') // Eager load bảng carDetails
        ->get();

        // Trả về view với dữ liệu cần thiết
        return view('Backend.rentalOrder.createRentalOrder', compact('rentalCars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rental_cars,rental_id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15|exists:accounts,phone',
            'start_date' => 'required|date|after_or_equal:today',
            'rental_days' => 'required|integer|min:1',
            'total_cost' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'rental_price_per_day' => 'required|numeric|min:0',
            'payment_type' => 'required|in:deposit,full',
        ]);

        DB::beginTransaction();

        try {
            $user = Account::where('phone', $request->phone)->first();

            if (!$user) {
                throw new \Exception('Không tìm thấy tài khoản với số điện thoại: ' . $request->phone);
            }

            $order = RentalOrder::create([
                'user_id' => $user->id,
                'rental_id' => $request->rental_id,
                'status' => 'Pending',
                'order_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $rentalEndDate = Carbon::parse($request->start_date)->addDays($request->rental_days - 1);

            RentalReceipt::create([
                'order_id' => $order->order_id,
                'rental_id' => $request->rental_id,
                'rental_start_date' => $request->start_date,
                'rental_end_date' => $rentalEndDate,
                'rental_price_per_day' => $request->rental_price_per_day,
                'total_cost' => $request->total_cost,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Xử lý logic thanh toán
            $paymentType = $request->payment_type;

            $mailData = [
                'name' => $request->name,
                'order_id' => $order->order_id,
                'start_date' => $request->start_date,
                'end_date' => $rentalEndDate,
                'total_cost' => $request->total_cost,
                'deposit_amount' => $paymentType === 'deposit' ? $request->deposit_amount : $request->total_cost,
            ];

            if ($paymentType === 'deposit') {
                $depositAmount = $request->deposit_amount;
                $remainingAmount = $request->total_cost - $depositAmount;
                $statusDeposit = 'Successful';
                $fullPaymentStatus = 'Pending';

                Mail::to($user->email)->send(new DepositSuccessfulNotification($mailData));
            } elseif ($paymentType === 'full') {
                $depositAmount = $request->total_cost;
                $remainingAmount = 0;
                $statusDeposit = 'Successful';
                $fullPaymentStatus = 'Successful';

                Mail::to($user->email)->send(new FullPaymentConfirmationMail($mailData));
            } else {
                throw new \Exception('Loại thanh toán không hợp lệ');
            }

            RentalPayment::create([
                'order_id' => $order->order_id,
                'status_deposit' => $statusDeposit,
                'full_payment_status' => $fullPaymentStatus,
                'deposit_amount' => $depositAmount,
                'total_amount' => $request->total_cost,
                'remaining_amount' => $remainingAmount,
                'due_date' => $paymentType === 'deposit' ? now()->addDays(7) : now(),
                'payment_date' => $paymentType === 'full' ? now() : null,
                'transaction_code' => uniqid('TXN-'),
            ]);

            // Cập nhật trạng thái đơn hàng
            if ($paymentType === 'deposit') {
                $order->update(['status' => 'Deposit Paid']);
            } elseif ($paymentType === 'full') {
                $order->update(['status' => 'Paid']);
            }

            // Cập nhật trạng thái xe
            $rentalCar = RentalCars::find($request->rental_id);
            if ($rentalCar) {
                $rentalCar->update(['availability_status' => 'Rented']);
            }

            DB::commit();

            toastr()->success($paymentType === 'deposit'
                ? 'Đơn hàng đã được tạo. Chờ khách hàng thanh toán đầy đủ.'
                : 'Đơn hàng đã được thanh toán toàn bộ.');

            return redirect()->route('rentalOrders');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi lưu đơn hàng: ' . $e->getMessage());
            toastr()->error('Có lỗi xảy ra. Vui lòng thử lại.');
            return redirect()->back()->withInput();
        }
    }

    public function completePayment($order_id)
    {
        DB::beginTransaction();
        try {
            // Lấy thông tin đơn hàng
            $order = RentalOrder::findOrFail($order_id);

            // Kiểm tra trạng thái đơn hàng
            if (!in_array($order->status, ['Pending', 'Deposit Paid'])) {
                toastr()->error('Đơn hàng không hợp lệ để thanh toán.');
                return redirect()->back();
            }

            // Lấy thông tin thanh toán
            $payment = RentalPayment::where('order_id', $order->order_id)->first();
            if (!$payment) {
                toastr()->error('Không tìm thấy thông tin thanh toán.');
                return redirect()->back();
            }

            // Lấy thông tin từ rental_receipt
            $rentalReceipt = RentalReceipt::where('order_id', $order->order_id)->first();
            if (!$rentalReceipt) {
                toastr()->error('Không tìm thấy thông tin hóa đơn thuê xe.');
                return redirect()->back();
            }

            // Cập nhật trạng thái thanh toán
            $payment->update([
                'status_deposit' => 'Successful',
                'full_payment_status' => 'Successful',
                'remaining_amount' => 0, // Đặt số tiền còn lại là 0
                'payment_date' => now(), // Cập nhật ngày thanh toán
            ]);

            // Cập nhật trạng thái đơn hàng
            $order->update([
                'status' => 'Paid', // Đơn hàng được đánh dấu là đã thanh toán
            ]);

            // Gửi mail xác nhận thanh toán toàn bộ
            $user = Account::find($order->user_id);
            if ($user) {
                $mailData = [
                    'name' => $user->name,
                    'order_id' => $order->order_id,
                    'start_date' => $rentalReceipt->rental_start_date,
                    'end_date' => $rentalReceipt->rental_end_date,
                    'total_cost' => $payment->total_amount,
                ];

                Mail::to($user->email)->send(new FullPaymentConfirmationMail($mailData));
            }

            DB::commit();

            toastr()->success('Thanh toán thành công. Đơn hàng đã được cập nhật.');
            return redirect()->route('rentalOrders');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi thanh toán đơn hàng: ' . $e->getMessage());
            toastr()->error('Có lỗi xảy ra. Vui lòng thử lại.');
            return redirect()->back();
        }
    }





}
