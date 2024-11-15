<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentalCars extends Model
{
    use HasFactory;

    protected $table = 'rental_cars';
    protected $primaryKey = 'rental_id';

    protected $fillable = [
        'car_id',
        'license_plate_number',
        'rental_price_per_day',
        'availability_status',
        'rental_conditions'
    ];

    public function carDetails()
    {
        return $this->belongsTo(CarDetails::class, 'car_id', 'car_id');
    }

    public function rentalReceipts()
    {
        return $this->hasMany(RentalReceipt::class, 'car_id', 'rental_id');
    }
}
