<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAccessory extends Model
{
    use HasFactory;

    protected $table = 'order_accessories'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'order_id',
        'accessory_id',
        'quantity',
        'price',
    ];

    /**
     * Quan hệ với Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * Quan hệ với Accessories
     */
    public function accessory()
    {
        return $this->belongsTo(Accessories::class, 'accessory_id', 'accessory_id');
    }
}
