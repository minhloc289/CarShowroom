<?php

namespace App\Imports;

use App\Models\CarDetails;
use App\Models\SalesCars;
use Maatwebsite\Excel\Concerns\ToModel;


class CarsImport implements ToModel
{


	public function model(array $row)
	{
		// Lấy các giá trị từ từng dòng
		$brand = $row[0];
		$name = $row[1];
		$model = $row[2];
		$year = (int) $row[3];  // Chuyển đổi năm thành kiểu số nguyên
		$engine_type = $row[4];
		$seat_capacity = (int) $row[5];  // Chuyển seat_capacity thành kiểu số nguyên
		$engine_power = $row[6];
		$max_speed = (int) filter_var($row[7], FILTER_SANITIZE_NUMBER_INT);  // Lấy số nguyên từ max_speed
		$trunk_capacity = $row[8];
		$length = $row[9];
		$width = $row[10];
		$height = $row[11];
		$description = $row[12];
		$sale_price = (int) $row[13];  // Kiểm tra kiểu dữ liệu sale_price
		$availability_status = $row[14];
		$warranty_period = (int) $row[15];  // Kiểm tra kiểu dữ liệu warranty_period
		$sale_conditions = $row[16];
		$image_url = $row[17];

		// Kiểm tra số lượng từ file Excel
		$quantity = (int) $row[18]; // Dữ liệu từ cột "số lượng"

		// Kiểm tra nếu các giá trị quan trọng không phải là số âm hoặc không hợp lệ
		if ($sale_price <= 0 || $quantity <= 0) {
			// Xử lý khi giá trị không hợp lệ
			return null; // Hoặc bạn có thể bỏ qua dòng này
		}

		// Kiểm tra xe đã có trong CarDetails chưa
		$carDetail = CarDetails::where([
			['brand', '=', $brand],
			['name', '=', $name],
			['model', '=', $model],
			['year', '=', $year]
		])->first();

		if ($carDetail) {
			// Cập nhật số lượng nếu xe đã có
			$salesCar = SalesCars::where('car_id', $carDetail->car_id)
				->where('sale_price', '=', $sale_price)
				->first();

			if ($salesCar) {
				// Cộng thêm số lượng vào
				$salesCar->quantity += $quantity;
				$salesCar->save();
			} else {
				// Nếu chưa có, tạo mới bản ghi trong SalesCars
				SalesCars::create([
					'car_id' => $carDetail->car_id,
					'sale_price' => $sale_price,
					'quantity' => $quantity,
					'availability_status' => $availability_status,
					'warranty_period' => $warranty_period,
					'sale_conditions' => $sale_conditions,
				]);
			}
		} else {
			// Nếu không có trong CarDetails, tạo mới CarDetails và SalesCars
			$carDetail = CarDetails::create([
				'brand' => $brand,
				'name' => $name,
				'model' => $model,
				'year' => $year,
				'engine_type' => $engine_type,
				'seat_capacity' => $seat_capacity,
				'engine_power' => $engine_power,
				'max_speed' => $max_speed,
				'trunk_capacity' => $trunk_capacity,
				'length' => $length,
				'width' => $width,
				'height' => $height,
				'description' => $description,
				'image_url' => $image_url,
			]);

			SalesCars::create([
				'car_id' => $carDetail->car_id,
				'sale_price' => $sale_price,
				'quantity' => $quantity,
				'availability_status' => $availability_status,
				'warranty_period' => $warranty_period,
				'sale_conditions' => $sale_conditions,
			]);
		}
	}
}
