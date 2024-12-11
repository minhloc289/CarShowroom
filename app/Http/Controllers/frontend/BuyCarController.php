<?php

namespace App\Http\Controllers\frontend;

use App\Models\CarDetails;
use App\Models\SalesCars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BuyCarController extends Controller
{
    public function showBuyForm($id)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::guard('account')->check()) {
            // Hiển thị thông báo lỗi bằng Toastr
            toastr()->error('Vui lòng đăng nhập để đặt cọc');
    
            // Chuyển hướng người dùng về trang đăng nhập hoặc trang khác
            return redirect()->back(); // Đảm bảo route 'customer.login' được định nghĩa
        }
    
        // Lấy thông tin xe từ CSDL
        $car = CarDetails::findOrFail($id);
    
        // Trả về view form mua xe với thông tin xe
        return view('frontend.Cars.buyForm', compact('car'));
    }
    

    // Phương thức xử lý việc mua xe
    // public function purchase(Request $request)
    // {
    //     // Xử lý các dữ liệu người dùng đã điền vào form
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'phone' => 'required|string|max:15',
    //         'car_id' => 'required|exists:cars,id', // Kiểm tra xe có tồn tại trong CSDL
    //     ]);

    //     // Xử lý mua xe (lưu vào cơ sở dữ liệu, gửi email, v.v.)
    //     // Ví dụ: Lưu thông tin đơn hàng hoặc thanh toán

    //     // Chuyển hướng tới trang cảm ơn hoặc thông báo thành công
    //     return redirect()->route('thankyou.page'); // Thay đổi route này với route thật của bạn
    // }
}
