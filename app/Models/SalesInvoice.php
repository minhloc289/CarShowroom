<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesInvoice extends Model
{
    use HasFactory;

    protected $table = 'sale_invoice'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'invoice_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'user_id',
        'seller_id',
        'invoice_date',
        'total_amount',
        'payment_status',
    ];
    /**
     * Thiết lập quan hệ belongsTo với bảng Account.
     */
    public function user()
    {
        return $this->belongsTo(Account::class, 'user_id', 'id');
    }

    /**
     * Thiết lập quan hệ belongsTo với bảng Users.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'invoice_id');
    }
    
}
