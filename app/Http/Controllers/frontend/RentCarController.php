<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarDetails;
use App\Models\RentalCars;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
            'rental_id' => 'required|exists:rental_cars,rental_id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15',
            'start_date' => 'required|date|after_or_equal:today',
            'rental_days' => 'required|integer|min:1', // Số ngày thuê
            'total_cost' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'rental_price_per_day' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Tạo đơn hàng (rental_order)
            $orderId = DB::table('rental_orders')->insertGetId([
                'user_id' => auth('account')->id(),
                'rental_id' => $request->rental_id, // Lấy rental_id từ form
                'status' => 'Pending', // Trạng thái ban đầu là 'Pending'
                'order_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tính ngày kết thúc thuê
            $rental_end_date = Carbon::parse($request->start_date)->addDays($request->rental_days - 1);

            // Lưu dữ liệu vào bảng rental_receipt
            DB::table('rental_receipt')->insert([
                'order_id' => $orderId, // Lấy ID của đơn hàng vừa tạo
                'rental_id' => $request->rental_id,
                'rental_start_date' => $request->start_date,
                'rental_end_date' => $rental_end_date,
                'rental_price_per_day' => $request->rental_price_per_day,
                'total_cost' => $request->total_cost,
                'status' => 'Active', // Trạng thái ban đầu là 'Active'
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Chuyển hướng sang trang thanh toán VNPAY
            return redirect()->route('rental.payment.vnpay', [
                'order_id' => $orderId,
                'total_amount' => $request->total_cost,
                'payment_deposit_amount' => $request->deposit_amount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Rental order creation failed: ' . $e->getMessage());

            toastr()->error('Có lỗi xảy ra. Vui lòng thử lại.');
            return redirect()->back()->withInput();
        }
    }


}
