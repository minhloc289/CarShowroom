<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'service_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'name',
        'description',
    ];

    // public function scheduleBookings()
    // {
    //     return $this->hasMany(ScheduleBooking::class, 'service_id', 'service_id');
    // }
}
