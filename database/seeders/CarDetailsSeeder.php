<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('car_details')->insert([
            [
                'brand' => 'Toyota',
                'name' => 'Camry',
                'model' => 'XSE',
                'year' => 2023,
                'engine_type' => 'Hybrid',
                'seat_capacity' => 5,
                'engine_power' => '203 HP',
                'max_speed' => 210,
                'trunk_capacity' => '15.1 cubic feet',
                'length' => 488.9,
                'width' => 184.3,
                'height' => 144.5,
                'image_url' => 'https://assets.porsche.com/vn/hanoi/-/media/Project/DealerWebsites/SharedDealersWebsite/Configurator-Teaser/911/911.jpg?rev=-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand' => 'Honda',
                'name' => 'Civic',
                'model' => 'EX',
                'year' => 2022,
                'engine_type' => 'Gasoline',
                'seat_capacity' => 5,
                'engine_power' => '180 HP',
                'max_speed' => 220,
                'trunk_capacity' => '14.8 cubic feet',
                'length' => 465.5,
                'width' => 180.0,
                'height' => 143.0,
                'image_url' => 'https://configurator.porsche.com/model-start/pictures/718/extcam01.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm 3 hàng dữ liệu nữa
        ]);
    }
}
