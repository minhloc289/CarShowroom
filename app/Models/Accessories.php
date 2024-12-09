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
    ];

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'accessory_id', 'accessory_id');
    }
    
    public function carts()
    {
        return $this->hasMany(Cart::class, 'accessory_id', 'accessory_id');
    }
}
