<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalPaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'rental_payment_details'; // Tên bảng
    protected $primaryKey = 'rental_payment_details_id'; // Khóa chính

    // Các trường có thể gán giá trị hàng loạt
    protected $fillable = [
        'payment_id',
        'date',
        'deposit_amount',
        'remaining_amount',
        'due_date',
    ];

    /**
     * Quan hệ với bảng RentalPayment
     */
    public function payment()
    {
        return $this->belongsTo(RentalPayment::class, 'payment_id', 'payment_id');
    }
}
