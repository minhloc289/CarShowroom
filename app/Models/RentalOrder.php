<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RentalCars;

class RentalOrder extends Model
{
    use HasFactory;

    protected $table = 'rental_orders'; // Tên bảng
    protected $primaryKey = 'order_id'; // Khóa chính

    protected $fillable = [
        'user_id',
        'rental_id',
        'status',
        'order_date',
    ];

    // Quan hệ với RentalReceipt (một đơn hàng có thể có nhiều biên lai thuê)
    public function rentalReceipts()
    {
        return $this->hasMany(RentalReceipt::class, 'order_id');
    }

    // Quan hệ với RentalPayment (một đơn hàng có thể có nhiều giao dịch thanh toán)
    public function rentalPayments()
    {
        return $this->hasMany(RentalPayment::class, 'order_id');
    }

    // Quan hệ với RentalCar (một đơn hàng có một chiếc xe)
    public function rentalCar()
    {
        return $this->belongsTo(RentalCars::class, 'rental_id');
    }

    public function user()
    {
        return $this->belongsTo(Account::class, 'user_id', 'id');
    }
}
