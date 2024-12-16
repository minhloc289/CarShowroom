<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalPayment extends Model
{
    use HasFactory;

    protected $table = 'rental_payments'; // Tên bảng
    protected $primaryKey = 'payment_id'; // Khóa chính

    protected $fillable = [
        'order_id',
        'status_deposit',
        'full_payment_status',
        'deposit_amount',
        'total_amount',
        'remaining_amount',
        'due_date',
        'payment_date',
        'transaction_code',
    ];

    // Quan hệ với RentalOrder (một giao dịch thanh toán thuộc về một đơn hàng)
    public function rentalOrder()
    {
        return $this->belongsTo(RentalOrder::class, 'order_id');
    }
}
