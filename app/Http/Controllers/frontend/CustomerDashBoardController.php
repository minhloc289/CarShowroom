<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account; // Đảm bảo đã import
use App\Models\Accessories;
use App\Models\RentalCar;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\CarDetails;

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
public function Bookingform(){
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


public function getAccessories()
{
    $accessories = Accessories::all(); // Lấy toàn bộ danh sách phụ kiện
    return response()->json($accessories); // Trả về dạng JSON
}

public function getSortedAccessories(Request $request)
{
    $sortType = $request->input('sort', 'newest'); // Lấy loại sắp xếp (mặc định là newest)
    
    if ($sortType === 'newest') {
        $accessories = Accessories::orderBy('updated_at', 'desc')->get(); // Sắp xếp theo mới nhất
    } elseif ($sortType === 'low-high') {
        $accessories = Accessories::orderBy('price', 'asc')->get(); // Sắp xếp giá từ thấp đến cao
    } elseif ($sortType === 'high-low') {
        $accessories = Accessories::orderBy('price', 'desc')->get(); // Sắp xếp giá từ cao đến thấp
    } else {
        $accessories = Accessories::all(); // Mặc định: lấy tất cả
    }

    return response()->json($accessories); // Trả về JSON
}

public function showAccessory($id)
{
    $accessory = Accessories::where('accessory_id', $id)->firstOrFail();
    return view('frontend.accessories.accessories_detail', compact('accessory'));
}

public function showCart()
{
    try {
        $user = Auth::guard('account')->user();

        if (!$user) {
            return response()->json([
                'message' => 'You need to log in first.',
            ], 401);
        }

        // Chỉ định rõ cột cần truy vấn
        $cartItems = Cart::with(['accessory:accessory_id,price,name,image_url'])
                        ->where('account_id', $user->id)
                        ->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->accessory->price;
        });

        $cartCount = $cartItems->sum('quantity');

        return view('frontend.accessories.cart', compact('cartItems', 'totalPrice', 'cartCount'));
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while fetching the cart.',
            'error' => $e->getMessage(),
        ], 500);
    }
}




//Car rent
    public function carRent(){
        $rental_car = CarDetails::with('rentalCars')->get();
        return view("frontend.car_rent.car_rent", compact('rental_car'));
    }

}
