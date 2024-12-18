<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Xác định người dùng có được phép thực hiện request này không.
     */
    public function authorize()
    {
        return true; // Cho phép thực hiện request
    }

    /**
     * Quy tắc kiểm tra dữ liệu đầu vào.
     */
    public function rules()
    {
        // Kiểm tra xem có tham số customerId hay không để xác định là cập nhật
        $customerId = $this->route('customerId'); 

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                $customerId 
                    ? 'unique:accounts,email,' . $customerId . ',id' // Bỏ qua bản ghi hiện tại khi cập nhật
                    : 'unique:accounts,email' // Kiểm tra duy nhất khi tạo mới
            ],
            'phone' => [
                'nullable',
                'digits_between:8,15',
                $customerId 
                    ? 'unique:accounts,phone,' . $customerId . ',id'
                    : 'unique:accounts,phone'
            ],
            'address' => 'nullable|string|max:255',
        ];
    }


    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'name.string' => 'Tên khách hàng phải là chuỗi ký tự.',
            'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',
            'phone.numeric' => 'Số điện thoại chỉ được chứa các chữ số.',
            'phone.digits_between' => 'Số điện thoại phải có từ 8 đến 15 chữ số.',
            'phone.unique' => 'Số điện thoại này đã tồn tại trong hệ thống.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ];
    }
}
