<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalCustomer extends Model
{
    use HasFactory;

    protected $table = 'rental_customers'; // Tên bảng
    protected $primaryKey = 'rental_id'; // Khóa chính

    protected $fillable = [
        'car_id',
        'customer_name',
        'phone_number',
        'email',
        'test_drive_date',
        'other_request',
    ];

    public function carDetails()
    {
        return $this->belongsTo(CarDetails::class, 'car_id', 'car_id');
    }
}
