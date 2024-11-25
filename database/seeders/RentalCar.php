<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalCar extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rental_cars')->insert([
            [
                'car_id' => 1, // ID từ bảng car_details
                'license_plate_number' => '51H-12345',
                'rental_price_per_day' => 1000000,
                'availability_status' => 'Available',
                'rental_conditions' => 'Không hút thuốc trong xe.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 2, // ID từ bảng car_details
                'license_plate_number' => '51G-56789',
                'rental_price_per_day' => 1200000,
                'availability_status' => 'Rented',
                'rental_conditions' => 'Không chở hàng hóa quá tải trọng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 3, // ID từ bảng car_details
                'license_plate_number' => '30F-98765',
                'rental_price_per_day' => 1500000,
                'availability_status' => 'Available',
                'rental_conditions' => 'Chỉ sử dụng trong khu vực TP.HCM.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 4, // ID từ bảng car_details
                'license_plate_number' => '29A-45678',
                'rental_price_per_day' => 2000000,
                'availability_status' => 'Rented',
                'rental_conditions' => 'Yêu cầu đặt trước 3 ngày.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 5, // ID từ bảng car_details
                'license_plate_number' => '52D-34567',
                'rental_price_per_day' => 1100000,
                'availability_status' => 'Available',
                'rental_conditions' => 'Không được chở quá số lượng người quy định.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

