<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motorcycle extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_RENTED = 'rented';
    public const STATUS_MAINTENANCE = 'maintenance';

    protected $fillable = [
        'category_id',
        'name',
        'plate_number',
        'price_per_day',
        'late_fee_per_day',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price_per_day' => 'decimal:2',
            'late_fee_per_day' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function availabilityOverrides(): HasMany
    {
        return $this->hasMany(MotorAvailabilityOverride::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function isAvailableOn(CarbonInterface $date): bool
    {
        if ($this->status === self::STATUS_MAINTENANCE) {
            return false;
        }

        $hasMaintenanceOverride = $this->availabilityOverrides()
            ->whereDate('date', $date->toDateString())
            ->where('status', MotorAvailabilityOverride::STATUS_MAINTENANCE)
            ->exists();

        if ($hasMaintenanceOverride) {
            return false;
        }

        return !$this->rentals()
            ->where('status', Rental::STATUS_ONGOING)
            ->whereDate('start_date', '<=', $date->toDateString())
            ->whereDate('estimated_return_date', '>=', $date->toDateString())
            ->exists();
    }

    public function syncRentalStatus(): void
    {
        if ($this->status === self::STATUS_MAINTENANCE) {
            return;
        }

        $hasOngoing = $this->rentals()->where('status', Rental::STATUS_ONGOING)->exists();
        $this->status = $hasOngoing ? self::STATUS_RENTED : self::STATUS_AVAILABLE;
        $this->saveQuietly();
    }
}
