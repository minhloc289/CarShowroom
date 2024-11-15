<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'account'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'gmail',
        'password',
    ];

    public function rentalReceipts()
        {
            return $this->hasMany(RentalReceipt::class, 'user_id', 'id');
        }

    public function scheduleBookings()
        {
            return $this->hasMany(ScheduleBooking::class, 'user_id', 'id');
        }

    public function testDriveRegistrations()
        {
            return $this->hasMany(TestDriveRegistration::class, 'user_id', 'id');
        }

}
