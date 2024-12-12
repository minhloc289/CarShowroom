<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarDetails;
use App\Models\RentalCars;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentCarController extends Controller
{
    public function carRent(){
        $rental_car = CarDetails::with('rentalCars')->get();
        return view("frontend.car_rent.car_rent", compact('rental_car'));
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết xe cùng thông tin thuê
        $car = CarDetails::with('rentalCars')->where('car_id', $id)->first();

        // Trường hợp không tìm thấy xe
        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        // Kiểm tra nếu không có thông tin thuê
        $rentalCar = $car->rentalCars->first();
        if (!$rentalCar) {
            return response()->json([
                'name' => $car->name,
                'brand' => $car->brand,
                'model' => $car->model,
                'year' => $car->year,
                'seat_capacity' => $car->seat_capacity,
                'max_speed' => $car->max_speed,
                'image_url' => $car->image_url,
                'rental_price_per_day' => null,
                'rental_conditions' => 'No rental conditions available.',
                'license_plate_number' => 'N/A',
            ]);
        }

        // Trả về thông tin chi tiết xe và thông tin thuê
        return response()->json([
            'name' => $car->name,
            'brand' => $car->brand,
            'model' => $car->model,
            'year' => $car->year,
            'seat_capacity' => $car->seat_capacity,
            'max_speed' => $car->max_speed,
            'image_url' => $car->image_url,
            'rental_price_per_day' => $rentalCar->rental_price_per_day,
            'rental_conditions' => $rentalCar->rental_conditions,
            'license_plate_number' => $rentalCar->license_plate_number,
        ]);
    }

    public function showRentForm($id)
    {
        // Lấy thông tin chi tiết xe kèm thông tin thuê
        $car = CarDetails::with('rentalCars')->where('car_id', $id)->first();

        // Kiểm tra nếu xe không tồn tại
        if (!$car) {
            return redirect()->route('rent.car')->with('error', 'Car not found.');
        }

        // Lấy thông tin cho thuê đầu tiên
        $rentalCar = $car->rentalCars->first();

        // Kiểm tra nếu không có thông tin thuê
        if (!$rentalCar) {
            return redirect()->route('rent.car')->with('error', 'No rental information available for this car.');
        }

        // Trả về thông tin chi tiết xe và thông tin thuê
        return view('frontend.car_rent.rentForm', compact('car', 'rentalCar'));
    }

    public function rentCar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15',
            'start_date' => 'required|date|after_or_equal:today',
            'total_cost' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
        ]);

        // Lưu dữ liệu vào bảng rental_receipt
        DB::table('rental_receipt')->insert([
            'user_id' => auth('account')->id(),
            'rental_id' => $request->rental_id, 
            'rental_start_date' => $request->start_date,
            'rental_end_date' => Carbon::parse($request->start_date)->addDays($request->rental_days - 1),
            'rental_price_per_day' => $request->rental_price_per_day,
            'total_cost' => $request->total_cost,
            'deposit_amount' => $request->deposit_amount,
            'remaining_amount' => $request->total_cost - $request->deposit_amount,
            'deposit_status' => 'Pending',
            'payment_status' => 'Unpaid',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('frontend.car_rent.car_rent')->with('success', 'Thuê xe thành công!');
    }


}
