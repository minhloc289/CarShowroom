<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
{
    use HasFactory;

    protected $table = 'accessories'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'accessory_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'name',
        'price',
        'description',
        'image_url',
        'category',
        'status',
        'quantity', // Thêm thuộc tính số lượng
    ];

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'accessory_id', 'accessory_id');
    }
    
    public function carts()
    {
        return $this->hasMany(Cart::class, 'accessory_id', 'accessory_id');
    }

    public function increaseQuantity($amount)
    {
        $this->quantity += $amount;

        // Nếu số lượng > 0, cập nhật trạng thái thành "Available"
        if ($this->quantity > 0) {
            $this->status = 'Available';
        }

        $this->save();
    }

    public function decreaseQuantity($amount)
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;

            // Nếu số lượng giảm về 0, cập nhật trạng thái thành "Out of stock"
            if ($this->quantity == 0) {
                $this->status = 'Out of stock';
            }

            $this->save();
        } else {
            // Nếu không đủ số lượng, cập nhật trạng thái và ném exception
            $this->status = 'Out of stock';
            $this->save();
            throw new \Exception('Số lượng không đủ để bán');
        }
    }

}
