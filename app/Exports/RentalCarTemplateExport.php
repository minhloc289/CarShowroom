<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RentalCarTemplateExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * Export an empty template with sample data.
     */
    public function collection()
    {
        // Dữ liệu mẫu cố định cho file Excel
        return collect([
            ['1', '51H-12345', '1000000', 'Không hút thuốc trong xe'],
            ['2', '30A-98765', '1500000', 'Chỉ sử dụng trong khu vực TP.HCM'],
            ['3', '29A-45678', '1200000', 'Yêu cầu đặt trước 3 ngày'],
        ]);
    }

    /**
     * Define the headings for the Excel file.
     */
    public function headings(): array
    {
        return [
            'car_id',                 // ID của xe
            'license_plate_number',   // Biển số xe
            'rental_price_per_day',   // Giá thuê mỗi ngày
            'rental_conditions',      // Điều kiện thuê
        ];
    }

    /**
     * Style the headings and data.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Căn giữa và in đậm cho hàng tiêu đề
            1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],
            
            // Tự động căn giữa các cột dữ liệu
            'A' => ['alignment' => ['horizontal' => 'center']],
            'B' => ['alignment' => ['horizontal' => 'center']],
            'C' => ['alignment' => ['horizontal' => 'center']],
            'D' => ['alignment' => ['horizontal' => 'left']],
        ];
    }
}
