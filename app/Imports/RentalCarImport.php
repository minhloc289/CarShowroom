<?php

namespace App\Imports;

use App\Models\RentalCars;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RentalCarImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * Xử lý từng dòng dữ liệu trong file Excel.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            RentalCars::create([
                'car_id' => $row['car_id'],
                'license_plate_number' => $row['license_plate_number'],
                'rental_price_per_day' => $row['rental_price_per_day'],
                'availability_status' => 'Available',
                'rental_conditions' => $row['rental_conditions'] ?? null,
            ]);
        }
    }


    /**
     * Quy tắc kiểm tra dữ liệu.
     */
    public function rules(): array
    {
        return [
            'car_id' => [
                'required',
                'exists:car_details,car_id',
                function ($attribute, $value, $fail) {
                    if (\App\Models\RentalCars::where('car_id', $value)->exists()) {
                        $fail("Xe có ID {$value} đã tồn tại.");
                    }
                },
            ],
            'license_plate_number' => 'required|unique:rental_cars,license_plate_number',
            'rental_price_per_day' => 'required|numeric|min:0',
            'rental_conditions' => 'nullable|string|max:255',
        ];
    }


    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function customValidationMessages()
    {
        return [
            'car_id.required' => 'ID xe là bắt buộc.',
            'car_id.exists' => 'ID xe không tồn tại trong danh sách xe.',
            'license_plate_number.required' => 'Biển số xe là bắt buộc.',
            'license_plate_number.unique' => 'Biển số xe đã tồn tại.',
            'rental_price_per_day.required' => 'Giá thuê mỗi ngày là bắt buộc.',
            'rental_price_per_day.numeric' => 'Giá thuê phải là số.',
            'rental_price_per_day.min' => 'Giá thuê phải lớn hơn hoặc bằng 0.',
        ];
    }
}
