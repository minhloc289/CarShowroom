<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDetails extends Model
{
    use HasFactory;

    protected $table = 'car_details'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'car_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'brand',
        'name',
        'model',
        'year',
        'engine_type',
        'seat_capacity',
        'engine_power',
        'max_speed',
        'trunk_capacity',
        'acceleration_time',
        'fuel_efficiency',
        'torque',
        'length',
        'width',
        'height',
        'image_url',
        'description',
    ];

    public function rentalCars()
    {
        return $this->hasMany(RentalCars::class, 'car_id', 'car_id');
    }
    public function sale()
    {
        return $this->hasOne(SalesCars::class, 'car_id', 'car_id');
    }
    public function salesCars()
    {
        return $this->hasMany(SalesCars::class, 'car_id', 'car_id');
    }

    public function testDriveRegistrations()
    {
        return $this->hasMany(TestDriveRegistration::class, 'car_id', 'car_id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'car_id', 'car_id');
    }


}
