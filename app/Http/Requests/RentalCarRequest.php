<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rentalId = $this->route('id'); // Lấy rental_id từ route

        return [
            'car_id' => [
                'required',
                'exists:car_details,car_id',
                function ($attribute, $value, $fail) use ($rentalId) {
                    // Kiểm tra car_id đã tồn tại trong bảng rental_cars ngoại trừ bản ghi hiện tại
                    if (\App\Models\RentalCars::where('car_id', $value)
                            ->where('rental_id', '!=', $rentalId)
                            ->exists()) {
                        $fail('Xe này đã được thêm vào danh sách thuê.');
                    }
                },
            ],
            'license_plate_number' => 'required|unique:rental_cars,license_plate_number,' . $rentalId . ',rental_id',
            'rental_price_per_day' => 'required|numeric|min:0',
            'availability_status' => $this->isMethod('PUT') ? 'required|in:Available,Rented' : '',
            'rental_conditions' => 'nullable|string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'car_id.required' => 'Vui lòng chọn xe.',
            'car_id.exists' => 'Xe không tồn tại trong hệ thống.',
            'license_plate_number.required' => 'Biển số xe là bắt buộc.',
            'license_plate_number.unique' => 'Biển số xe đã tồn tại.',
            'rental_price_per_day.required' => 'Giá thuê mỗi ngày là bắt buộc.',
            'rental_price_per_day.numeric' => 'Giá thuê phải là số.',
            'rental_price_per_day.min' => 'Giá thuê không được nhỏ hơn 0.',
            'rental_conditions.string' => 'Điều kiện thuê phải là chuỗi văn bản.',
            'rental_conditions.max' => 'Điều kiện thuê không được vượt quá 255 ký tự.',
        ];
    }
}
