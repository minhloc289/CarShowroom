<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReceipt extends Model
{
    use HasFactory;

    protected $table = 'rental_receipt'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'receipt_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'user_id',
        'rental_id',
        'rental_start_date',
        'rental_end_date',
        'rental_price_per_day',
        'total_cost',
        'deposit_amount',
        'remaining_amount',
        'deposit_status',
        'payment_status',
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
}
