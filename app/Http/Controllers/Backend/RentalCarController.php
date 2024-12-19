<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalCars;
use App\Models\CarDetails;
use App\Http\Requests\RentalCarRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RentalCarTemplateExport;
use App\Imports\RentalCarImport;
use Maatwebsite\Excel\Validators\ValidationException;

class RentalCarController extends Controller
{
    public function loadRentalCar()
    {
        // Lấy danh sách các xe từ rental_cars mà is_deleted = false
        $rentalCars = RentalCars::with('carDetails') // Eager load car details
            ->where('is_deleted', false) // Điều kiện is_deleted = false
            ->get();

        // Lấy dữ liệu bổ sung cho bộ lọc
        $seatCapacities = CarDetails::distinct()->pluck('seat_capacity');
        $brands = CarDetails::distinct()->pluck('brand');

        // Truyền dữ liệu vào view
        return view('Backend.Product.RentalCar.RentalCar', compact('rentalCars', 'seatCapacities', 'brands'));
    }

    public function filterRentalCars(Request $request)
    {
        $query = RentalCars::with('carDetails')->where('is_deleted', false);

        // Tìm kiếm
        if ($request->search) {
            $query->whereHas('carDetails', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('brand', 'like', '%' . $request->search . '%')
                ->orWhere('model', 'like', '%' . $request->search . '%');
            });
        }

        // Tình trạng
        if ($request->status) {
            $query->where('availability_status', $request->status);
        }

        // Số chỗ ngồi
        if ($request->seatCapacity) {
            $query->whereHas('carDetails', function ($q) use ($request) {
                $q->where('seat_capacity', $request->seatCapacity);
            });
        }

        // Thương hiệu
        if ($request->brand) {
            $query->whereHas('carDetails', function ($q) use ($request) {
                $q->where('brand', $request->brand);
            });
        }

        // Giá thuê
        if ($request->minPrice) {
            $query->where('rental_price_per_day', '>=', $request->minPrice);
        }
        if ($request->maxPrice) {
            $query->where('rental_price_per_day', '<=', $request->maxPrice);
        }

        $cars = $query->get()->map(function ($rentalCar) {
            return [
                'rental_id' => $rentalCar->rental_id, // Thêm rental_id
                'car_id' => $rentalCar->car_id,       // Thêm car_id
                'image_url' => $rentalCar->carDetails->image_url,
                'brand' => $rentalCar->carDetails->brand,
                'model' => $rentalCar->carDetails->model,
                'name' => $rentalCar->carDetails->name,
                'license_plate_number' => $rentalCar->license_plate_number,
                'availability_status' => $rentalCar->availability_status,
                'rental_price_per_day' => number_format($rentalCar->rental_price_per_day, 2)
            ];
        });

        return response()->json(['cars' => $cars]);
    }

    public function showDetails($id)
    {
        // Lấy thông tin từ car_details
        $carDetail = CarDetails::findOrFail($id);

        // Lấy thông tin từ rental_cars dựa trên car_id
        $rentalCar = RentalCars::where('car_id', $id)->first();

        return view('Backend.Product.RentalCar.RentalCarDetails', compact('rentalCar', 'carDetail'));
    }

    public function loadCreateForm()
    {
        $carDetails = CarDetails::all();
        return view('Backend.Product.RentalCar.CreateRentalCar', compact('carDetails'));
    }

    public function store(RentalCarRequest $request)
    {
        // Lưu thông tin vào bảng rental_cars
        RentalCars::create([
            'car_id' => $request->car_id,
            'license_plate_number' => $request->license_plate_number,
            'rental_price_per_day' => $request->rental_price_per_day,
            'rental_conditions' => $request->rental_conditions,
        ]);
        toastr()->success('Thêm xe thuê thành công');
        return redirect()->route('rentalCar');
    }

    public function loadEditForm($id)
    {
        // Tìm xe thuê dựa trên car_id
        $rentalCar = RentalCars::with('carDetails')->where('car_id', $id)->firstOrFail();

        // Lấy danh sách tất cả xe từ car_details để chọn lại nếu cần
        $carDetails = CarDetails::all();

        return view('Backend.Product.RentalCar.EditRentalCar', compact('rentalCar', 'carDetails'));
    }


    public function update(RentalCarRequest $request, $id)
    {
        $rentalCar = RentalCars::findOrFail($id);

        $rentalCar->update([
            'car_id' => $request->car_id,
            'license_plate_number' => $request->license_plate_number,
            'rental_price_per_day' => $request->rental_price_per_day,
            'availability_status' => $request->availability_status,
            'rental_conditions' => $request->rental_conditions,
        ]);

        toastr()->success('Cập nhật thông tin xe thuê thành công!');
        return redirect()->route('rentalCar');
    }

    public function delete($id)
    {
        // Tìm xe thuê dựa trên rental_id
        $rentalCar = RentalCars::findOrFail($id);

        // Cập nhật trường is_deleted
        $rentalCar->update(['is_deleted' => true]);

        toastr()->success('Xe thuê đã được xóa thành công!');
        return redirect()->route('rentalCar');
    }

    public function loadRentalExcel()
    {
        return view('Backend.Product.RentalCar.CreateRecordRentalCar');
    }

    public function downloadTemplate()
    {
        return Excel::download(new RentalCarTemplateExport, 'rental_car_template.xlsx');
    }

    public function importExcel(Request $request)
    {
        // Validate file tải lên
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ], [
            'file.required' => 'Vui lòng chọn file Excel.',
            'file.mimes' => 'File phải có định dạng xlsx hoặc xls.',
        ]);

        try {
            // Import dữ liệu từ file
            Excel::import(new RentalCarImport, $request->file('file'));
            toastr()->success('Dữ liệu xe thuê đã được nhập thành công!');
            return redirect()->route('rentalCar');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Bắt lỗi validation và gửi toastr
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $row = $failure->row(); // Dòng bị lỗi
                $attribute = $failure->attribute(); // Cột bị lỗi
                $errors = implode(', ', $failure->errors()); // Các lỗi

                toastr()->error("Dòng {$row} - Cột {$attribute}: {$errors}");
            }
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteMultiple(Request $request)
    {
        $rentalIds = $request->input('rental_ids');

        // Giải mã JSON nếu cần
        if (is_string($rentalIds)) {
            $rentalIds = json_decode($rentalIds, true); // Chuyển JSON string thành mảng
        }

        // Kiểm tra nếu không phải mảng hoặc mảng rỗng
        if (!is_array($rentalIds) || count($rentalIds) === 0) {
            toastr()->error('Vui lòng chọn ít nhất một xe để xóa.');
            return redirect()->back();
        }

        // Cập nhật is_deleted = 1 cho các rental_id được chọn
        RentalCars::whereIn('rental_id', $rentalIds)->update(['is_deleted' => 1]);
        toastr()->success('Các xe thuê đã được đánh dấu là xóa.');
        return redirect()->back();
    }




}
