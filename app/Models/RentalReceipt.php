<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReceipt extends Model
{
    use HasFactory;

    protected $table = 'rental_receipt'; // Tên bảng
    protected $primaryKey = 'receipt_id'; // Khóa chính

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'rental_id',
        'order_id',
        'rental_start_date',
        'rental_end_date',
        'rental_price_per_day',
        'total_cost',
        'status',
    ];

    /**
     * Thiết lập quan hệ belongsTo với bảng Account.
     */
    public function user()
    {
        return $this->belongsTo(Account::class, 'user_id', 'id');
    }

    /**
     * Thiết lập quan hệ belongsTo với bảng RentalCars.
     */
    public function rentalCar()
    {
        return $this->belongsTo(RentalCars::class, 'rental_id', 'rental_id');
    }

    public function rentalOrder()
    {
        return $this->belongsTo(RentalOrder::class, 'order_id');
    }

    public function renewals()
    {
        return $this->hasMany(RentalRenewal::class, 'receipt_id', 'receipt_id');
    }
}
