<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders'; // Tên bảng
    protected $primaryKey = 'order_id'; // Khóa chính
    public $incrementing = false; // Không tự động tăng
    protected $keyType = 'string'; // Loại khóa chính là string

    protected $fillable = [
        'order_id',
        'account_id',
        'sale_id',
        'status_order',
        'order_date', // Thêm thuộc tính vào $fillable
    ];

    /**
     * Quan hệ với Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Quan hệ với SalesCars
     */
    public function salesCar()
    {
        return $this->belongsTo(SalesCars::class, 'sale_id', 'sale_id');
    }

    /**
     * Quan hệ với Payment
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id', 'order_id');
    }

    /**
     * Boot method - Tạo ID tự động với tiền tố ORD
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastOrder = Order::orderBy('order_id', 'desc')->first();
            $nextId = $lastOrder ? ((int)substr($lastOrder->order_id, 3)) + 1 : 1;
            $model->order_id = 'ORD' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            // Gán ngày hiện tại nếu chưa có
            if (!$model->order_date) {
                $model->order_date = now()->toDateString();
            }
        });
    }
}