<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\SalesCars;
use Illuminate\Http\Request;

class carSalesController extends Controller
{
    public function loadCarsales()
    {
        $engineTypes = CarDetails::distinct()->pluck('engine_type'); // Lấy danh sách engine_type duy nhất
        $seatCapacities = CarDetails::distinct()->pluck('seat_capacity'); // Lấy danh sách seat_capacity duy nhất
        $brands = CarDetails::distinct()->pluck('brand'); // Lấy danh sách brand duy nhất    
        $cars = CarDetails::with('salesCars')->get(); // Lấy dữ liệu từ bảng `car_details` và liên kết với `sales_cars`
        return view('Backend.Product.CarSales',compact('cars','engineTypes','seatCapacities','brands'));
    }
    public function show_details_Car($carId)
    {
        // Lấy thông tin chi tiết của xe
        $carDetail = CarDetails::findOrFail($carId);
        
        // Lấy thông tin của xe từ bảng sales_cars (nếu có)
        $salesCar = SalesCars::where('car_id', $carId)->first();

        return view('Backend.Product.Cardetails', compact('carDetail', 'salesCar'));
    }
    public function show_edit_car($carId)
    {
        $carDetail = CarDetails::findOrFail($carId); // Lấy thông tin từ car_details
        $salesCar = SalesCars::where('car_id', $carId)->first(); // Lấy thông tin từ sales_cars
    
        return view('Backend.Product.CarEdit', compact('carDetail', 'salesCar'));
    }

    // Cập nhật thông tin xe
    public function update_car_edit(Request $request, $carId)
    {
        // Lấy thông tin từ bảng car_details
    $carDetail = CarDetails::findOrFail($carId);

    // Lấy thông tin từ bảng sales_cars
    $salesCar = SalesCars::where('car_id', $carId)->first();

    // Validate dữ liệu đầu vào
    $request->validate([
        'brand' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'image_url' => 'required|url',
        'engine_type' => 'required|string|max:255',
        'seat_capacity' => 'required|integer|min:1',
        'engine_power' => 'required|string|max:255', // VD: "616 HP"
        'max_speed' => 'required|numeric|min:1',
        'trunk_capacity' => 'required|string|max:255', // VD: "12 cubic feet"
        'length' => 'required|numeric|min:1',
        'width' => 'required|numeric|min:1',
        'height' => 'required|numeric|min:1',
        'description' => 'nullable|string|max:2000',

        // Validate dữ liệu từ sales_cars
        'sale_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'availability_status' => 'required|boolean',
        'warranty_period' => 'nullable|integer|min:0',
        'sale_conditions' => 'nullable|string|max:1000',
    ]);

    // Cập nhật dữ liệu vào bảng car_details
    $carDetail->update([
        'brand' => $request->brand,
        'name' => $request->name,
        'model' => $request->model,
        'image_url' => $request->image_url,
        'engine_type' => $request->engine_type,
        'seat_capacity' => $request->seat_capacity,
        'engine_power' => $request->engine_power, // Lưu chuỗi như "616 HP"
        'max_speed' => $request->max_speed,
        'trunk_capacity' => $request->trunk_capacity, // Lưu chuỗi như "12 cubic feet"
        'length' => $request->length,
        'width' => $request->width,
        'height' => $request->height,
        'description' => $request->description,
    ]);

    // Cập nhật hoặc tạo mới dữ liệu vào bảng sales_cars
    if ($salesCar) {
        $salesCar->update([
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'availability_status' => $request->availability_status,
            'warranty_period' => $request->warranty_period,
            'sale_conditions' => $request->sale_conditions,
        ]);
    } else {
        SalesCars::create([
            'car_id' => $carId,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'availability_status' => $request->availability_status,
            'warranty_period' => $request->warranty_period,
            'sale_conditions' => $request->sale_conditions,
        ]);
    }

    // Redirect về trang danh sách xe hoặc chi tiết xe
    toastr()->success('Cập nhật thông tin xe thành công');
    return redirect()->route('Carsales');
}
}
