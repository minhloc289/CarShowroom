<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDriveRegistration extends Model
{
    use HasFactory;

    protected $table = 'test_drive_registration'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'registration_id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'user_id',
        'car_id',
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
     * Thiết lập quan hệ belongsTo với bảng CarDetails.
     */
    public function carDetails()
    {
        return $this->belongsTo(CarDetails::class, 'car_id', 'car_id');
    }
}
