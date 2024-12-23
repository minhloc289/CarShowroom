<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRenewal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rental_renewals';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'renewal_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receipt_id',
        'request_date',
        'new_end_date',
        'renewal_cost',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'request_date' => 'datetime',
        'new_end_date' => 'datetime',
        'renewal_cost' => 'decimal:2',
    ];

    /**
     * Get the rental receipt associated with the renewal.
     */
    public function rentalReceipt()
    {
        return $this->belongsTo(RentalReceipt::class, 'receipt_id', 'receipt_id');
    }
}
