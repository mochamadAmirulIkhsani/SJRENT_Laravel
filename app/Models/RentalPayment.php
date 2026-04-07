<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalPayment extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (RentalPayment $payment): void {
            $payment->created_by ??= auth()->id();
        });
    }

    public const TYPE_RENT_DOWN_PAYMENT = 'rent_down_payment';
    public const TYPE_RENT_FULL = 'rent_full';
    public const TYPE_LATE_FEE = 'late_fee';
    public const TYPE_ADDITIONAL_FEE = 'additional_fee';

    protected $fillable = [
        'rental_id',
        'amount',
        'payment_type',
        'payment_date',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
