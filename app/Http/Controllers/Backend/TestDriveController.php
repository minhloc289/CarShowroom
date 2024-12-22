<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalCustomer; // Import Model RentalCustomer
use App\Models\CarDetails; // Import Model CarDetails nếu cần

class TestDriveController extends Controller
{
    public function index()
    {
        $rental = RentalCustomer::with('carDetails')
                ->orderBy('test_drive_date', 'asc')
                ->get();

        // Trả về view và truyền dữ liệu
        return view('Backend.customer.customer-test-drive.customer_overview', compact('rental'));
    }

    public function loadCustomerCreatePage()
    {
        $cars = CarDetails::whereHas('salesCars', function ($query) {
            $query->where('is_deleted', 0);
        })->with('sale')->get();
        $carsByBrand = $cars->groupBy('brand');
        return view('backend.customer.customer-test-drive.customer_create', [
            'carsByBrand' => $carsByBrand->toArray()
        ]);
    }

    public function delete($rental_id)
    {
        // Tìm khách hàng cần xóa
        $rental = RentalCustomer::findOrFail($rental_id);

        // Xóa khách hàng
        $rental->delete();

        toastr()->success('Xóa khách hàng thành công.');
        return redirect()->route('test_drive.index');
    }

}