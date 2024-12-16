<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $imagePath = $row['image'] ?? null; // Placeholder for image logic

            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone'] ?? null,
                'address' => $row['address'] ?? null,
                'birthday' => $row['birthday'] ?? null,
                'image' => $imagePath,
                'description' => $row['description'] ?? null,
                'is_quanly' => ($row['level'] === 'Admin') ? 1 : 0,
                'user_agent' => request()->header('User-Agent'),
                'password' => Hash::make('minhlocdeptrai'),
                'level' => ($row['level'] === 'Admin') ? 'Admin' : 'Nhân viên',
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'level' => 'required|in:Admin,Nhân viên',
            'phone' => 'nullable|numeric',
            'birthday' => 'nullable|date',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'email.required' => 'Email là bắt buộc.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.unique'   => 'Email đã tồn tại trong hệ thống.',
            'name.required'  => 'Tên nhân viên là bắt buộc.',
        ];
    }
}
