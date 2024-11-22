<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; // Đảm bảo đã import
use App\Models\Accessories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
class CustomerDashBoardController extends Controller
{
    public function index(){
        return view("frontend.home.home");
    }
     /**
     * Hiển thị form đăng nhập.
     *
     * @return \Illuminate\View\View
     */
   
//compare
public function compare(){
    return view("frontend.compareCar.compare_car");
}
//booking form
public function bookingform(){
    return view("frontend.Booking_form.booking_form");
}

// accessories
function accessories(){
    $accessories = Accessories::all(); // Lấy toàn bộ danh sách phụ kiện
    return view('frontend.accessories.accessories', compact('accessories'));
}
public function showDashboard()
{
    $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    return view('frontend.CustomerDashBoard.index', compact('user'));
}
// Introduce
public function introduce(){
    return view("frontend.Introduce.Introduce");
}
// Register
public function registration(){
    return view("frontend.registration_drive.register");
}
}
