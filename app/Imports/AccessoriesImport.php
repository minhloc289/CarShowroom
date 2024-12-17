<?php

namespace App\Imports;

use App\Models\Accessories;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class AccessoriesImport implements ToModel
{
    public function model(array $row)
    {
        $validCategories = ['Interior', 'Exterior', 'Car Care'];

        // Lấy các giá trị từ từng dòng
        $name        = $row[0];
        $category    = in_array($row[1], $validCategories) ? $row[1] : null;
        $price       = (int) $row[2];
        $quantity    = (int) $row[3];
        $description = $row[4];
        $image_url   = $row[5];

        // Kiểm tra dữ liệu hợp lệ
        if ($price <= 0 || $quantity <= 0 || is_null($category)) {
            Log::warning("Dữ liệu dòng không hợp lệ (bỏ qua): ", $row);
            return null;
        }

        // Kiểm tra phụ kiện đã tồn tại hay chưa
        $accessory = Accessories::where([
            ['name', '=', $name],
            ['category', '=', $category],
            ['price', '=', $price]
        ])->first();

        if ($accessory) {
            $accessory->increaseQuantity($quantity); // Cập nhật số lượng và trạng thái
        } else {
            Accessories::create([
                'name'        => $name,
                'category'    => $category,
                'price'       => $price,
                'quantity'    => $quantity,
                'description' => $description,
                'image_url'   => $image_url,
            ]);
        }
    }
}

