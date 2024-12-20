<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasFactory;

    protected $table = 'accounts'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'id'; // Khóa chính của bảng

    public $incrementing = false; // Khóa chính không tự động tăng vì bạn đã tùy chỉnh

    public $timestamps = true; // Bật timestamps (created_at, updated_at)

    protected $keyType = 'string'; // Kiểu dữ liệu của khóa chính

    protected $fillable = [
        'email',
        'password',
        'name',       // Họ tên
        'address',    // Địa chỉ
        'phone',      // Số điện thoại
        'is_verified', // Trạng thái xác thực tài khoản
        'email_verification_token', // Token xác minh email
    ];

    protected $hidden = [
        'password',      // Ẩn password khi xuất dữ liệu ra ngoài
        'remember_token' // Ẩn remember_token (nếu sử dụng)
    ];

    /**
     * Quan hệ với các bảng khác
     */
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

    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoice::class, 'user_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'account_id', 'id');
    }

    public function rentalOrders()
    {
        return $this->hasMany(RentalOrder::class, 'user_id', 'id');
    }

    /**
     * Boot method - Tạo ID tự động với tiền tố ACC
     */
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
