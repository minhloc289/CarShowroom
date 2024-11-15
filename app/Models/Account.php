<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'id'; // Khóa chính của bảng

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $fillable = [
        'email',
        'password',
    ];

    // public function rentalReceipts()
    //     {
    //         return $this->hasMany(RentalReceipt::class, 'user_id', 'id');
    //     }

    // public function scheduleBookings()
    //     {
    //         return $this->hasMany(ScheduleBooking::class, 'user_id', 'id');
    //     }

    // public function testDriveRegistrations()
    //     {
    //         return $this->hasMany(TestDriveRegistration::class, 'user_id', 'id');
    //     }

    protected $hidden = [
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Tự động tạo id với tiền tố "ACC" và định dạng "ACC001", "ACC002",...
            $lastAccount = Account::orderBy('id', 'desc')->first();
            $nextId = $lastAccount ? ((int)substr($lastAccount->id, 3)) + 1 : 1;
            $model->id = 'ACC' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        });
    }
}
