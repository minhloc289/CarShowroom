<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\SalesCars;

class CarController extends Controller
{
    public function index()
    {
        $engineTypes = CarDetails::distinct()->pluck('engine_type'); // Lấy danh sách engine_type duy nhất
        $seatCapacities = CarDetails::distinct()->pluck('seat_capacity'); // Lấy danh sách seat_capacity duy nhất
        $brands = CarDetails::distinct()->pluck('brand'); // Lấy danh sách brand duy nhất    
        $cars = CarDetails::whereHas('salesCars', function ($query) {
            $query->where('is_deleted', 0)
                  ->where('quantity', '>', 0);
        })->with('salesCars')->get();
        // Lấy dữ liệu từ bảng `car_details` và liên kết với `sales_cars`
        return view("frontend.Cars.cars", compact('cars', 'engineTypes', 'seatCapacities', 'brands'));
    }
    public function show($car_id)
    {
        // Lấy thông tin xe dựa trên car_id
        $engineTypes = CarDetails::distinct()->pluck('engine_type'); // Lấy danh sách engine_type duy nhất
        $seatCapacities = CarDetails::distinct()->pluck('seat_capacity'); // Lấy danh sách seat_capacity duy nhất
        $brands = CarDetails::distinct()->pluck('brand'); // Lấy danh sách brand duy nhất  
        $cars = CarDetails::with('salesCars')->get(); // Lấy dữ liệu từ bảng `car_details` và liên kết với `sales_cars`
        $car = CarDetails::with('sale')->findOrFail($car_id);

        // Trả về view cùng thông tin xe
        return view('frontend.Cars.detailscar', compact('car', 'cars', 'engineTypes', 'seatCapacities', 'brands'));
    }
}
