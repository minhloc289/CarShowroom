<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Tên bảng
    protected $primaryKey = 'payment_id'; // Khóa chính

    public $incrementing = true; // ID tự động tăng
    public $timestamps = true; // Bật timestamps

    protected $fillable = [
        'account_id',        // ID tài khoản
        'status',            // Trạng thái thanh toán
        'payment_detail_id', // ID chi tiết thanh toán
        'transaction_code',  // Mã giao dịch
        'total_amount',      // Tổng số tiền giao dịch
    ];

    /**
     * Quan hệ với bảng Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Quan hệ với bảng PaymentDetails
     */
    public function paymentDetail()
    {
        return $this->belongsTo(PaymentDetails::class, 'payment_detail_id', 'payment_details_id');
    }
}
