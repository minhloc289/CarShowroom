<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesCars extends Model
{
    use HasFactory;

    protected $table = 'sales_cars';
    protected $primaryKey = 'sale_id';

    // Các thuộc tính có thể gán hàng loạt
    protected $fillable = [
        'car_id',
        'sale_price',
        'quantity',
        'is_deleted',
        'availability_status',
        'warranty_period',
        'sale_conditions',
    ];

    // Định nghĩa mối quan hệ belongsTo với bảng CarDetails
    public function carDetails()
    {
        return $this->belongsTo(CarDetails::class, 'car_id', 'car_id');
    }
    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetails::class, 'sale_id', 'sale_id');
    }

}
