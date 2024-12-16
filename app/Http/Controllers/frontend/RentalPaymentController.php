<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RentalCars;
use App\Models\RentalPayment;
use App\Models\RentalOrder;

class RentalPaymentController extends Controller
{
    /**
     * Xử lý thanh toán qua VNPAY.
     */
    public function vnpay_payment(Request $request)
    {
        // Lấy thông tin từ request
        $orderId = $request->input('order_id'); // ID của đơn hàng
        $paymentDepositAmount = str_replace(',', '', $request->input('payment_deposit_amount')); // Số tiền đặt cọc
        $totalAmount = str_replace(',', '', $request->input('total_amount')); // Tổng tiền
        $remainingAmount = $totalAmount - $paymentDepositAmount; // Số dư còn lại

        // Kiểm tra tồn tại của đơn hàng
        $order = RentalOrder::find($orderId);
        if (!$order) {
            return redirect()->back()->withErrors(['error' => 'Đơn hàng không tồn tại.']);
        }

        // Tạo mã giao dịch duy nhất
        $vnp_TxnRef = uniqid();

        // Tạo bản ghi trong bảng rental_payments
        RentalPayment::create([
            'order_id' => $orderId,
            'status_deposit' => 'Pending',
            'full_payment_status' => 'Pending',
            'deposit_amount' => $paymentDepositAmount,
            'total_amount' => $totalAmount,
            'remaining_amount' => $remainingAmount,
            'due_date' => now()->addMinutes(5),
            'payment_date' => now(),
            'transaction_code' => $vnp_TxnRef,
        ]);

        // Cấu hình VNPAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('rental.payment.vnpay_return'); // Đường dẫn trả về sau khi thanh toán
        $vnp_TmnCode = "YNHSYV2M"; // Mã website tại VNPAY
        $vnp_HashSecret = "ATCT9RJYIMSNQ47T8J3AAM87W3NPPQS8"; // Chuỗi bí mật
        $vnp_BankCode = '';
        
        $vnp_Amount = (float)$paymentDepositAmount * 100;; // Đơn vị VND * 100
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_OrderInfo = 'Thanh toán hóa đơn thuê xe #ORDER-' . $orderId;

        // Tạo dữ liệu cho VNPAY
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Ký hash dữ liệu
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Redirect người dùng tới URL thanh toán
        return redirect()->away($vnp_Url);

    }


    /**
     * Xử lý kết quả trả về từ VNPAY.
     */
    public function vnpay_return(Request $request)
    {
        $vnp_HashSecret = "ATCT9RJYIMSNQ47T8J3AAM87W3NPPQS8"; // Chuỗi bí mật
        $inputData = $request->all();

        // Lấy hash từ dữ liệu trả về
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        // Ký lại dữ liệu
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        $hashData = trim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                $transactionCode = $inputData['vnp_TxnRef'] ?? null;
                if ($transactionCode) {
                    $payment = RentalPayment::where('transaction_code', $transactionCode)->first();
                    if ($payment) {
                        $order = RentalOrder::find($payment->order_id);
                        $payment->update(['status_deposit' => 'Successful']);
                        if ($order) {
                            $order->update(['status' => 'Deposit Paid']);
                            if ($payment->remaining_amount <= 0) {
                                $payment->update(['full_payment_status' => 'Successful']);
                                $order->update(['status' => 'Paid']); // Cập nhật trạng thái đơn hàng là 'Paid'
                                // Cập nhật trạng thái xe thuê
                                $rental = RentalCars::find($order->rental_id);
                                if ($rental) {
                                    $rental->update(['availability_status' => 'Rented']);
                                }
                            }
                        }
                    }
                }
                toastr()->success("Thanh toán thành công");
                return redirect()->route('rent.car');
            } else {
                toastr()->error("Thanh toán thất bại");
                return redirect()->route('rent.car');
            }
        } else {
            toastr()->error("Chữ ký không hợp lệ");
            return redirect()->route('rent.car');
        }
    }

    public function updateFullPaymentStatus(Request $request, $paymentId)
    {
        $request->validate([
            'payment_id' => 'required|exists:rental_payments,payment_id',
        ]);

        // Tìm payment
        $payment = RentalPayment::find($paymentId);

        if (!$payment) {
            toastr()->error("Không tìm thấy thông tin thanh toán.");
            return redirect()->back();
        }

        // Kiểm tra nếu thanh toán còn lại đã thực hiện
        if ($payment->remaining_amount > 0) {
            $payment->update([
                'remaining_amount' => 0, // Số dư còn lại là 0
                'full_payment_status' => 'Successful', // Đánh dấu đã thanh toán đầy đủ
                'payment_date' => now(), // Cập nhật thời gian thanh toán
            ]);

            // Cập nhật trạng thái order
            $order = RentalOrder::find($payment->order_id);
            if ($order) {
                $order->update(['status' => 'Paid']);

                // Cập nhật trạng thái xe
                $rentalCar = RentalCars::find($order->rental_id);
                if ($rentalCar) {
                    $rentalCar->update(['availability_status' => 'Rented']);
                }
            }

            toastr()->success("Cập nhật trạng thái thanh toán thành công.");
            return redirect()->route('order.details', ['id' => $order->order_id]);
        } else {
            toastr()->warning("Thanh toán đã được hoàn tất trước đó.");
            return redirect()->back();
        }
    }


}
