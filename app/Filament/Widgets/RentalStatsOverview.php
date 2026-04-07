<?php

namespace App\Filament\Widgets;

use App\Models\Motorcycle;
use App\Models\Rental;
use App\Models\RentalPayment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RentalStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Motor tersedia', Motorcycle::query()->where('status', Motorcycle::STATUS_AVAILABLE)->count())
                ->description('Unit siap disewa saat ini')
                ->color('success'),
            Stat::make('Motor disewa', Motorcycle::query()->where('status', Motorcycle::STATUS_RENTED)->count())
                ->description('Sedang aktif di transaksi ongoing')
                ->color('warning'),
            Stat::make('Pendapatan hari ini', RentalPayment::query()->whereDate('payment_date', now())->sum('amount'))
                ->description('Total pembayaran masuk hari ini')
                ->color('success'),
            Stat::make('Jatuh tempo hari ini', Rental::query()->where('status', Rental::STATUS_ONGOING)->whereDate('estimated_return_date', now())->count())
                ->description('Perlu diproses pengembaliannya')
                ->color('danger'),
        ];
    }
}
