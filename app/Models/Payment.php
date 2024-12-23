<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Tên bảng
    protected $primaryKey = 'payment_id'; // Khóa chính
    public $incrementing = false; // Không tự động tăng
    protected $keyType = 'string'; // Loại khóa chính là string

    protected $fillable = [
        'payment_id',
        'order_id',
        'VNPAY_ID',
        'payment_deposit_date',
        'status_deposit',
        'status_payment_all',
        'deposit_amount',
        'remaining_payment_date',
        'full_payment_date',
        'remaining_amount',
        'total_amount',
        'deposit_deadline',
        'payment_deadline',
    ];
    /**
     * Quan hệ với Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * Boot method - Tạo ID tự động với tiền tố PAY
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastPayment = Payment::orderBy('payment_id', 'desc')->first();
            $nextId = $lastPayment ? ((int)substr($lastPayment->payment_id, 3)) + 1 : 1;
            $model->payment_id = 'PAY' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        });
    }
}
