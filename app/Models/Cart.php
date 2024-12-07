<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'account_id',    // ID người dùng
        'accessory_id',  // ID phụ kiện
        'quantity',      // Số lượng
    ];

    /**
     * Quan hệ với bảng accounts.
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * Quan hệ với bảng accessories.
     */
    public function accessory()
    {
        return $this->belongsTo(Accessories::class, 'accessory_id', 'accessory_id');
    }

    /**
     * Tính tổng giá trị của mục trong giỏ hàng.
     */
    public function getTotalPriceAttribute()
    {
        return $this->accessory ? $this->accessory->price * $this->quantity : 0;
    }
}
