<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalPayment extends Model
{
    use HasFactory;

    protected $table = 'rental_payments'; // Tên bảng
    protected $primaryKey = 'payment_id'; // Khóa chính

    // Các trường có thể gán giá trị hàng loạt
    protected $fillable = [
        'account_id',
        'receipt_id',
        'status',
        'transaction_code',
        'total_amount',
    ];

    /**
     * Quan hệ với bảng RentalReceipt
     */
    public function receipt()
    {
        return $this->belongsTo(RentalReceipt::class, 'receipt_id', 'receipt_id');
    }

    /**
     * Quan hệ với bảng RentalPaymentDetails
     */
    public function paymentDetails()
    {
        return $this->hasMany(RentalPaymentDetail::class, 'payment_id', 'payment_id');
    }
}
