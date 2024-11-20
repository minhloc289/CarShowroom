<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales_cars')->insert([
            [
                'car_id' => 1,
                'sale_price' => 35000.00,
                'availability_status' => 'Available',
                'warranty_period' => 36,
                'sale_conditions' => 'No damages, full service history included.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 2,
                'sale_price' => 25000.00,
                'availability_status' => 'Sold',
                'warranty_period' => 24,
                'sale_conditions' => 'Certified pre-owned, no additional fees.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm 3 hàng dữ liệu nữa
        ]);
    }
}
