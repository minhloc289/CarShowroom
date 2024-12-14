<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Đảm bảo đã import
use App\Models\Payment; // Đảm bảo đã import



class paymentcontroller extends Controller
{
    
    public function vnpay_payment(Request $request){
            // Lấy thông tin từ request
    $paymentDepositAmount = str_replace(',', '', $request->input('payment_deposit_amount'));
    $saleId = $request->input('sale_id');
    $totalPrice = $request->input('total-price');
    $accountId = Auth::guard('account')->id(); // Lấy account_id từ người dùng đang đăng nhập
    $remainingAmount = str_replace(',', '', $request->input('remaining_amount'));

    // Tạo bản ghi trong bảng payment_details

    $vnp_TxnRef = uniqid(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
    $vnp_OrderInfo = 'Thanh toán hóa đơn cọc xe';
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = (float)$paymentDepositAmount* 10000;
    $vnp_Locale ='VN';
    $vnp_BankCode = '';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    // Tạo bản ghi trong bảng payments
    // Tạo bản ghi trong bảng orders
    $order = new Order();
    $order->order_id = 'ORD' . time(); // Hoặc sử dụng logic tạo ID phù hợp
    $order->account_id = Auth::guard('account')->id();
    $order->sale_id = $saleId;
    $order->status_order = 0; // Pending
    $order->order_date = now();
    $order->save();

    // Tạo bản ghi trong bảng payments
    $payment = new Payment();
    $payment->payment_id = 'PAY' . time(); // Hoặc sử dụng logic tạo ID phù hợp
    $payment->order_id = $order->order_id;
    $payment->VNPAY_ID = $vnp_TxnRef;
    $payment->status_deposit = 0; // Pending
    $payment->status_payment_all = 0; // Pending
    $payment->deposit_amount = $paymentDepositAmount;
    $payment->remaining_amount = $remainingAmount;
    $payment->total_amount = $totalPrice;
    $payment->deposit_deadline = now()->addDays(1); // Ví dụ: hạn đặt cọc là 7 ngày
    $payment->payment_deadline = now()->addDays(30); // Ví dụ: hạn thanh toán đầy đủ là 30 ngày
    $payment->save();
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://127.0.0.1:8000/payment/vnpay-return";
    $vnp_TmnCode = "G3B8D56Z";//Mã website tại VNPAY 
    $vnp_HashSecret = "VDUWTWV5XTR62YVIPCWY4J5L684BOIM7"; //Chuỗi bí mật
    

    //Add Params of 2.0.1 Version
    // $vnp_ExpireDate = $_POST['txtexpire'];
    //Billing
    
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }
    
    //var_dump($inputData);
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
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
     }
     public function vnpay_return(Request $request)
     {
         $vnp_HashSecret = "VDUWTWV5XTR62YVIPCWY4J5L684BOIM7"; // Chuỗi bí mật của bạn
         $inputData = $request->all();
     
         // Lấy SecureHash từ VNPAY để kiểm tra tính hợp lệ
         $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
         unset($inputData['vnp_SecureHash']);
         unset($inputData['vnp_SecureHashType']);
     
         // Sắp xếp và tạo chuỗi hash
         ksort($inputData);
         $hashData = "";
         foreach ($inputData as $key => $value) {
             $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
         }
         $hashData = trim($hashData, '&');
         $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
     
         if ($secureHash === $vnp_SecureHash) {
             // Kiểm tra trạng thái giao dịch từ VNPAY
             if ($inputData['vnp_ResponseCode'] == '00') {
                 // Lấy mã giao dịch từ VNPAY
                 $transactionCode = $inputData['vnp_TxnRef'] ?? null;
     
                 if ($transactionCode) {
                     // Tìm payment dựa trên VNPAY_ID
                     $payment = Payment::where('VNPAY_ID', $transactionCode)->first();
     
                     if ($payment) {
                         // Cập nhật trạng thái thanh toán thành công
                         $payment->update([
                             'status_deposit' => 1, // Cập nhật trạng thái cọc thành công
                             'payment_deposit_date' => now(), // Ghi nhận ngày thanh toán
                         ]);
     
                         // Cập nhật trạng thái order tương ứng
                         // Thông báo thành công
                         toastr()->success("Đặt cọc thành công");
                         return redirect()->route('CarController.index');
                     }
                 }
     
                 // Nếu không tìm thấy payment
                 toastr()->error("Không tìm thấy giao dịch liên kết!");
                 return redirect()->route('CarController.index');
             } else {
                 // Trường hợp giao dịch thất bại
                 toastr()->error("Giao dịch thất bại, vui lòng thử lại!");
                 return redirect()->route('CarController.index');
             }
         } else {
             // Chữ ký không hợp lệ
             return redirect()->route('CarController.index')->with('error', 'Chữ ký không hợp lệ!');
         }
     }
     
}
