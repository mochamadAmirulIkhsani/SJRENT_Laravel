<?php

namespace App\Filament\Widgets;

use App\Models\RentalPayment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class RentalRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Pendapatan 6 Bulan';

    protected ?string $description = 'Arus pembayaran masuk per bulan';

    protected ?string $maxHeight = '300px';

    protected string $color = 'warning';

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($offset = 5; $offset >= 0; $offset--) {
            $month = Carbon::now()->subMonths($offset)->startOfMonth();
            $labels[] = $month->translatedFormat('M Y');
            $values[] = (float) RentalPayment::query()
                ->whereBetween('payment_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penerimaan pembayaran',
                    'data' => $values,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#b45309',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
