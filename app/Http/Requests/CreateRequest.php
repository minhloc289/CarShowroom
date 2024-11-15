<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'image' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'user_agent' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

    }

    public function messages()
    {
        return [
            'email.required' => 'Email là trường bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'name.required' => 'Tên là trường bắt buộc',
            'name.string' => 'Tên phải là chuỗi ký tự',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'photo.image' => 'File phải là hình ảnh',
            'photo.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'photo.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        toastr()->error($validator->errors()->first());
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}
