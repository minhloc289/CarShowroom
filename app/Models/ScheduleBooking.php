<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleBooking extends Model
{
    use HasFactory;

    protected $table = 'schedule_booking'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'booking_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'user_id',
        'service_id',
        'preferred_date',
        'status',
    ];

    /**
     * Thiết lập quan hệ belongsTo với bảng Account.
     */
    public function user()
    {
        return $this->belongsTo(Account::class, 'user_id', 'id');
    }

    /**
     * Thiết lập quan hệ belongsTo với bảng Service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}
