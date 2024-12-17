<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CarExport;
use App\Http\Controllers\Controller;
use App\Models\CarDetails;
use App\Models\SalesCars;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CarsImport;

class carSalesController extends Controller
{
    public function loadCarsales()
    {
        $engineTypes = CarDetails::distinct()->pluck('engine_type'); // Lấy danh sách engine_type duy nhất
        $seatCapacities = CarDetails::distinct()->pluck('seat_capacity'); // Lấy danh sách seat_capacity duy nhất
        $brands = CarDetails::distinct()->pluck('brand'); // Lấy danh sách brand duy nhất    
        $cars = CarDetails::whereHas('salesCars', function ($query) {
            $query->where('is_deleted', 0);
        })->with('sale')->get(); // Lấy dữ liệu từ bảng `car_details` và liên kết với `sales_cars`
        return view('Backend.Product.CarSales', compact('cars', 'engineTypes', 'seatCapacities', 'brands'));
    }
    public function create()
    {
        return view('Backend.Product.Carcreate');  // Chỉ đến view tạo xe mới
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

    public function destroy($carId)
    {
        // Tìm dòng dựa trên carId hoặc trả về lỗi 404 nếu không tìm thấy
        $saleCar = SalesCars::findOrFail($carId);

        // Cập nhật is_deleted thành 1
        $saleCar->is_deleted = 1;

        if ($saleCar->save()) {
            // Cập nhật thành công
            toastr()->success('Đã xóa thành công xe.');
            return redirect()->back();
        }

        // Cập nhật thất bại
        toastr()->error('Xóa xe không thành công');
        return redirect()->back();

    }

    public function destroySelected(Request $request)
    {
        // Kiểm tra xem có ít nhất một carId trong request không
        $carIds = $request->input('car_ids');

        if (empty($carIds)) {
            toastr()->error('Không có xe nào được chọn');
            return redirect()->route('Carsales');
        }

        // Chuyển đổi chuỗi carIds thành mảng nếu nó là chuỗi
        $carIdsArray = explode(',', $carIds[0]);

        // Biến đếm số lượng xe được cập nhật
        $updatedCount = 0;

        // Dùng vòng lặp để cập nhật trạng thái is_deleted của từng xe
        foreach ($carIdsArray as $carId) {
            // Tìm từng xe trong bảng SalesCars
            $saleCar = SalesCars::where('car_id', $carId)->first();

            if ($saleCar) {
                // Cập nhật is_deleted thành 1
                $saleCar->is_deleted = 1;

                if ($saleCar->save()) {
                    $updatedCount++;
                }
            }
        }

        // Kiểm tra và hiển thị thông báo
        if ($updatedCount > 0) {
            toastr()->success("Đã chuyển trạng thái 'đã xóa' cho {$updatedCount} xe thành công.");
        } else {
            toastr()->error('Không thể cập nhật trạng thái cho xe nào.');
        }

        return redirect()->route('Carsales');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'engine_type' => 'required|string|max:255',
            'seat_capacity' => 'required|integer|min:1',
            'engine_power' => 'required|string|max:255',
            'max_speed' => 'required|integer|min:1',
            'trunk_capacity' => 'required|string|max:255',
            'length' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'height' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'sale_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'availability_status' => 'required|boolean',
            'warranty_period' => 'nullable|integer|min:0',
            'sale_conditions' => 'nullable|string',
            'image_url' => 'required|url', // Xác thực URL hình ảnh
        ]);

        // Kiểm tra xem xe đã tồn tại trong CarDetails chưa
        $carDetail = CarDetails::where([
            ['brand', '=', $request->brand],
            ['name', '=', $request->name],
            ['model', '=', $request->model],
            ['year', '=', $request->year]
        ])->first();

        if ($carDetail) {
            // Nếu xe đã tồn tại trong CarDetails
            // Kiểm tra xem xe đã có thông tin bán (SalesCars) chưa
            $salesCar = SalesCars::where('car_id', $carDetail->car_id)
                ->where('sale_price', '=', $request->sale_price)
                ->first();

            if ($salesCar) {
                // Nếu đã có thông tin bán xe, cập nhật quantity và is_deleted
                $salesCar->quantity += $request->quantity;
                $salesCar->is_deleted = 0; // Đặt lại is_deleted về 0
                $salesCar->save();
            } else {
                // Nếu không có thông tin bán xe, tạo mới thông tin bán xe
                SalesCars::create([
                    'car_id' => $carDetail->car_id,
                    'sale_price' => $request->sale_price,
                    'quantity' => $request->quantity,
                    'availability_status' => $request->availability_status,
                    'warranty_period' => $request->warranty_period,
                    'sale_conditions' => $request->sale_conditions,
                    'is_deleted' => 0, // Đảm bảo is_deleted là 0 cho xe mới
                ]);
            }
        } else {
            // Nếu xe không tồn tại trong CarDetails, tạo mới cả CarDetails và SalesCars
            $carDetail = CarDetails::create([
                'brand' => $request->brand,
                'name' => $request->name,
                'model' => $request->model,
                'year' => $request->year,
                'engine_type' => $request->engine_type,
                'seat_capacity' => $request->seat_capacity,
                'engine_power' => $request->engine_power,
                'max_speed' => $request->max_speed,
                'trunk_capacity' => $request->trunk_capacity,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'description' => $request->description,
                'image_url' => $request->image_url, // Lưu URL hình ảnh vào CarDetails
            ]);

            // Tạo mới thông tin bán xe và liên kết với CarDetails
            SalesCars::create([
                'car_id' => $carDetail->car_id,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'availability_status' => $request->availability_status,
                'warranty_period' => $request->warranty_period,
                'sale_conditions' => $request->sale_conditions,
                'is_deleted' => 0, // Đảm bảo is_deleted là 0 cho xe mới
            ]);
        }

        toastr()->success('Thêm thành công xe mới.');
        return redirect()->back();
    }

    public function showUploadForm()
    {
        return view('Backend.Product.upload');
    }
    public function import(Request $request)
    {
        // Kiểm tra nếu có file được upload
        if ($request->hasFile('file')) {
            // Lấy đường dẫn của file
            $path = $request->file('file')->getRealPath();

            // Nhập dữ liệu từ file Excel
            Excel::import(new CarsImport, $path);
            toastr()->success('Thêm thành công xe');
            return redirect()->back();
        }
        toastr()->error('Vui lòng kiểm tra lại file');

        return back();
    }
    public function downloadTemplate()
    {
        return Excel::download(new CarExport, 'car_add_template.xlsx');
    }
}
