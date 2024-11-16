<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'invoice_detail'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'detail_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'invoice_id',
        'car_id',
        'accessory_id',
        'service_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    /**
     * Thiết lập quan hệ belongsTo với bảng SaleInvoice.
     */
    public function saleInvoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'invoice_id', 'invoice_id');
    }

    /**
     * Thiết lập quan hệ belongsTo với bảng CarDetails.
     */
    public function carDetails()
    {
        return $this->belongsTo(CarDetails::class, 'car_id', 'car_id');
    }

    /**
     * Thiết lập quan hệ belongsTo với bảng Accessories.
     */
    public function accessories()
    {
        return $this->belongsTo(Accessories::class, 'accessory_id', 'accessory_id');
    }

    /**
     * Thiết lập quan hệ belongsTo với bảng Services.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}
