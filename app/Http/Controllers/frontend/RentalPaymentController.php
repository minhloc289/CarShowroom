<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RentalCars;
use App\Models\RentalPayment;
use App\Models\RentalOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\DepositSuccessfulNotification;
use Carbon\Carbon;
use App\Models\RentalReceipt;
use App\Models\RentalRenewal;

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
                        $payment->update([
                            'status_deposit' => 'Successful',
                            'due_date' => now()->addMinutes(5),
                        ]);
                        if ($order) {
                            $order->update(['status' => 'Deposit Paid']);
                            $rental = RentalCars::find($order->rental_id);
                            if ($rental) {
                                $rental->update(['availability_status' => 'Rented']);
                            }

                            // Lấy dữ liệu từ bảng rental_receipt
                            $rentalReceipt = DB::table('rental_receipt')->where('order_id', $order->order_id)->first();

                            // Gửi email xác nhận đặt cọc thành công
                            try {
                                Mail::to($order->user->email)->send(new DepositSuccessfulNotification([
                                    'name' => $order->user->name,
                                    'order_id' => $order->order_id,
                                    'start_date' => $rentalReceipt->rental_start_date,
                                    'end_date' => $rentalReceipt->rental_end_date,
                                    'deposit_amount' => $payment->deposit_amount,
                                    'total_cost' => $payment->total_amount,
                                ]));

                                toastr()->success("Thanh toán đặt cọc thành công và email xác nhận đã được gửi.");
                            } catch (\Exception $e) {
                                Log::error('Gửi email thất bại: ' . $e->getMessage());
                                toastr()->warning("Thanh toán đặt cọc thành công nhưng không gửi được email xác nhận.");
                            }
                        }
                    }
                }
                return redirect()->route('rent.car');
            } else {
                toastr()->error("Thanh toán đặt cọc thất bại");
                return redirect()->route('rent.car');
            }
        } else {
            toastr()->error("Chữ ký không hợp lệ");
            return redirect()->route('rent.car');
        }
    }

    public function vnpay_payment_renewal(Request $request)
    {
        // Lấy thông tin từ request
        $orderId = $request->query('order_id');
        $amount = $request->query('amount');
        $renewalType = $request->query('renewal_type');
        $renewalId = $request->query('renewal_id'); 

        session([
            'renewal_id' => $renewalId,
            'renewal_type' => $renewalType,
        ]);

        // Kiểm tra tồn tại của đơn hàng
        $order = RentalOrder::findOrFail($orderId);

        // Tạo mã giao dịch duy nhất
        $vnp_TxnRef = uniqid();

        // Tạo bản ghi trong bảng rental_payments
        RentalPayment::create([
            'order_id' => $orderId,
            'status_deposit' => 'Pending',
            'full_payment_status' => 'Pending',
            'deposit_amount' => 0,
            'total_amount' => $amount,
            'remaining_amount' => 0,
            'due_date' => now()->addMinutes(2),
            'payment_date' => now(),
            'transaction_code' => $vnp_TxnRef,
        ]);

        // Cấu hình VNPAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('rental.payment.vnpay_return_renewal'); // Đường dẫn trả về sau khi thanh toán
        $vnp_TmnCode = "YNHSYV2M"; // Mã website tại VNPAY
        $vnp_HashSecret = "ATCT9RJYIMSNQ47T8J3AAM87W3NPPQS8"; // Chuỗi bí mật
        $vnp_BankCode = '';

        $vnp_Amount = $amount * 100; // Đơn vị VND * 100
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_OrderInfo = 'Thanh toán gia hạn hóa đơn #' . $orderId;

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

        return redirect()->away($vnp_Url);
    }

    public function vnpay_return_renewal(Request $request)
    {
        $vnp_HashSecret = "ATCT9RJYIMSNQ47T8J3AAM87W3NPPQS8"; // Chuỗi bí mật
        $inputData = $request->all();
        $renewalId = session('renewal_id');
        $renewalType = session('renewal_type');

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
                    $payment = RentalPayment::where('transaction_code', $transactionCode)->firstOrFail();
                    if ($payment) {
                        $order = RentalOrder::find($payment->order_id);
                        $payment->update([
                            'full_payment_status' => 'Successful',
                            'status_deposit' => 'Successful',
                            'payment_date' => now(),
                        ]);

                        if ($order) {
                            $order->update(['status' => 'Paid']);
                            $renewal = RentalRenewal::findOrFail($renewalId);
                            $receipt = $renewal->rentalReceipt;

                            if ($renewalType === 'active') {
                                // Trường hợp hợp đồng còn hạn
                                RentalReceipt::create([
                                    'rental_id' => $receipt->rental_id,
                                    'order_id' => $order->order_id,
                                    'rental_start_date' => $receipt->rental_start_date,
                                    'rental_end_date' => $renewal->new_end_date,
                                    'rental_price_per_day' => $receipt->rental_price_per_day,
                                    'total_cost' => $renewal->renewal_cost,
                                    'status' => 'Active',
                                    'is_renewal' => true,
                                ]);
                            } elseif ($renewalType === 'completed') {
                                // Trường hợp hợp đồng đã hết hạn
                                RentalReceipt::create([
                                    'rental_id' => $receipt->rental_id,
                                    'order_id' => $order->order_id,
                                    'rental_start_date' => Carbon::now()->hour >= 22 
                                        ? Carbon::now()->addDay()->startOfDay()
                                        : Carbon::now(),
                                    'rental_end_date' => $renewal->new_end_date,
                                    'rental_price_per_day' => $receipt->rental_price_per_day,
                                    'total_cost' => $renewal->renewal_cost,
                                    'status' => 'Active',
                                    'is_renewal' => true,
                                ]);

                                $rental = RentalCars::find($order->rental_id);
                                if ($rental) {
                                    $rental->update(['availability_status' => 'Rented']);
                                }
                            }

                            // Gửi email thông báo
                            try {
                                Mail::to($order->user->email)->send(new \App\Mail\PaymentSuccessfulNotification([
                                    'name' => $order->user->name,
                                    'order_id' => $order->order_id,
                                    'receipt_id' => $receipt->receipt_id,
                                    'start_date' => Carbon::parse($receipt->rental_start_date)->format('d-m-Y'),
                                    'end_date' => Carbon::parse($renewal->new_end_date)->format('d-m-Y'),
                                    'total_cost' => (float) $renewal->renewal_cost,
                                ]));

                                toastr()->success('Thanh toán gia hạn thành công. Email xác nhận đã được gửi.');
                            } catch (\Exception $e) {
                                toastr()->warning('Thanh toán gia hạn thành công nhưng không gửi được email xác nhận.');
                            }
                        }
                    }
                }

                return redirect()->route('rentalHistory');
            } else {
                toastr()->error('Thanh toán gia hạn thất bại.');
                return redirect()->route('rentalHistory');
            }
        } else {
            toastr()->error('Chữ ký không hợp lệ.');
            return redirect()->route('rentalHistory');
        }
    }

}
