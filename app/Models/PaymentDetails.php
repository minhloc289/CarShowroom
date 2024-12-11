<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $table = 'payment_details'; // Tên bảng
    protected $primaryKey = 'payment_details_id'; // Khóa chính

    public $incrementing = true; // ID tự động tăng
    public $timestamps = true; // Bật timestamps

    protected $fillable = [
        'date',            // Ngày đặt cọc
        'sale_id',         // Khóa ngoại đến bảng sales_cars
        'deposit_amount',  // Số tiền đặt cọc
        'remaining_amount', // Số tiền còn lại
        'due_date',        // Hạn chót thanh toán
    ];

    /**
     * Quan hệ với bảng SalesCars
     */
    public function salesCar()
    {
        return $this->belongsTo(SalesCars::class, 'sale_id', 'sale_id');
    }

    /**
     * Quan hệ với bảng Payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'payment_detail_id', 'payment_details_id');
    }
}
