<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Authenticatable
{
    use HasFactory;

    protected $table = 'accounts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'email',
        'password',
    ];

    // Ẩn trường password khi trả về dạng mảng hoặc JSON
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
