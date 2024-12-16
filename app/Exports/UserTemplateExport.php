<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserTemplateExport implements WithHeadings, WithStyles, WithColumnWidths, FromArray
{
    /**
     * Tiêu đề của các cột
     */
    public function headings(): array
    {
        return ['name', 'email', 'phone', 'address', 'birthday', 'image', 'description', 'level'];
    }

    /**
     * Dữ liệu mẫu
     */
    public function array(): array
    {
        return [
            ['Nguyễn Văn A', 'example1@gmail.com', '0123456789', '123 Đường ABC', '1990-01-01', 'avatar1.jpg', 'Nhân viên IT', 'Admin'],
            ['Trần Thị B', 'example2@gmail.com', '0987654321', '456 Đường XYZ', '1995-05-20', 'avatar2.jpg', 'Nhân viên Marketing', 'User'],
        ];
    }

    /**
     * Định dạng style cho các ô
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:H1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    /**
     * Độ rộng của các cột
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // name
            'B' => 30, // email
            'C' => 15, // phone
            'D' => 25, // address
            'E' => 15, // birthday
            'F' => 20, // image
            'G' => 30, // description
            'H' => 10, // level
        ];
    }

    
}
