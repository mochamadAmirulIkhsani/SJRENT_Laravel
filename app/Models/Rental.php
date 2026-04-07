<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;

class Rental extends Model
{
    use HasFactory;

    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'customer_id',
        'motorcycle_id',
        'start_date',
        'estimated_return_date',
        'actual_return_date',
        'total_rent_days',
        'total_rent_price',
        'late_days',
        'late_fee',
        'additional_fee',
        'grand_total',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'estimated_return_date' => 'date',
            'actual_return_date' => 'date',
            'total_rent_price' => 'decimal:2',
            'late_fee' => 'decimal:2',
            'additional_fee' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Rental $rental): void {
            $rental->created_by ??= auth()->id();
        });

        static::saving(function (Rental $rental): void {
            $rental->applyRentPricing();
            $rental->ensureNoOverlap();
        });

        static::saved(function (Rental $rental): void {
            $rental->motorcycle?->syncRentalStatus();
        });

        static::deleted(function (Rental $rental): void {
            $rental->motorcycle?->syncRentalStatus();
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(RentalPayment::class);
    }

    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ONGOING);
    }

    public function processReturn(?Carbon $returnedAt = null, float $additionalFee = 0): void
    {
        $returnedAt ??= now();

        if ($this->status !== self::STATUS_ONGOING) {
            throw ValidationException::withMessages([
                'status' => 'Hanya transaksi ongoing yang dapat diproses pengembaliannya.',
            ]);
        }

        $estimated = Carbon::parse($this->estimated_return_date);
        $lateDays = $returnedAt->greaterThan($estimated)
            ? $estimated->diffInDays($returnedAt)
            : 0;

        $lateFee = $lateDays * (float) $this->motorcycle->late_fee_per_day;

        $this->fill([
            'actual_return_date' => $returnedAt->toDateString(),
            'late_days' => $lateDays,
            'late_fee' => $lateFee,
            'additional_fee' => $additionalFee,
            'status' => self::STATUS_COMPLETED,
        ]);

        $this->applyRentPricing();
        $this->save();
    }

    public function applyRentPricing(): void
    {
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->estimated_return_date);
        $days = max(1, $start->diffInDays($end) + 1);

        $basePrice = $days * (float) ($this->motorcycle?->price_per_day ?? 0);
        $lateFee = (float) ($this->late_fee ?? 0);
        $additionalFee = (float) ($this->additional_fee ?? 0);

        $this->total_rent_days = $days;
        $this->total_rent_price = $basePrice;
        $this->grand_total = $basePrice + $lateFee + $additionalFee;
    }

    public function ensureNoOverlap(): void
    {
        if ($this->status !== self::STATUS_ONGOING || !$this->motorcycle_id) {
            return;
        }

        $conflictExists = self::query()
            ->where('motorcycle_id', $this->motorcycle_id)
            ->where('status', self::STATUS_ONGOING)
            ->when($this->exists, fn (Builder $query) => $query->whereKeyNot($this->getKey()))
            ->whereDate('start_date', '<=', Carbon::parse($this->estimated_return_date)->toDateString())
            ->whereDate('estimated_return_date', '>=', Carbon::parse($this->start_date)->toDateString())
            ->exists();

        if ($conflictExists) {
            throw ValidationException::withMessages([
                'motorcycle_id' => 'Motor sudah digunakan pada rentang tanggal tersebut.',
            ]);
        }
    }
}
