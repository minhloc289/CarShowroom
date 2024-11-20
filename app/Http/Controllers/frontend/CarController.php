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
        $cars = CarDetails::with('salesCars')->get(); // Lấy dữ liệu từ bảng `car_details` và liên kết với `sales_cars`
            return view("frontend.Cars.cars", compact('cars'));
    }
}
