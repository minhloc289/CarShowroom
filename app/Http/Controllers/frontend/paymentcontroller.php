<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentDetails; // Đảm bảo đã import
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
    $paymentDetail = PaymentDetails::create([
        'date' => now(),
        'sale_id' => $saleId,
        'deposit_amount' => $paymentDepositAmount,
        'remaining_amount' => $remainingAmount,
        'due_date' => now()->addDays(1), // Giả định hạn chót là 7 ngày sau
    ]);
    $vnp_TxnRef = uniqid(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
    $vnp_OrderInfo = 'Thanh toán hóa đơn cọc xe';
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = (float)$paymentDepositAmount* 100;
    $vnp_Locale ='VN';
    $vnp_BankCode = '';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    // Tạo bản ghi trong bảng payments
    $payment = Payment::create([
        'account_id' => $accountId,
        'payment_detail_id' => $paymentDetail->payment_details_id,
        'status' => 0, // Mặc định là Pending
        'transaction_code' => $vnp_TxnRef,
        'total_amount' => $totalPrice,
    ]);
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
     
         $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
         unset($inputData['vnp_SecureHash']);
         unset($inputData['vnp_SecureHashType']);
     
         ksort($inputData);
         $hashData = "";
         foreach ($inputData as $key => $value) {
             $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
         }
         $hashData = trim($hashData, '&');
         $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
     
         if ($secureHash === $vnp_SecureHash) {
             // Kiểm tra trạng thái giao dịch
             if ($inputData['vnp_ResponseCode'] == '00') {
                 // Lấy mã giao dịch từ input
                 $transactionCode = $inputData['vnp_TxnRef'] ?? null;
     
                 if ($transactionCode) {
                     // Tìm payment dựa trên mã giao dịch
                     $payment = Payment::where('transaction_code', $transactionCode)->first();
     
                     if ($payment) {
                         // Cập nhật trạng thái thành công
                         $payment->update(['status' => 1]);
                     }
                 }
     
                 // Hiển thị trang CarController.index với thông báo thành công
                toastr()->success("Đặt cọc thành công");
                 
                 return redirect()->route('CarController.index');
             } else {
                 // Hiển thị trang CarController.index với thông báo thất bại
                toastr()->success("Đặt cọc thất bại");

                 return redirect()->route('CarController.index');
             }
         } else {
             // Sai chữ ký
             return redirect()->route('CarController.index')->with('error', 'Chữ ký không hợp lệ!');
         }
     }

}
