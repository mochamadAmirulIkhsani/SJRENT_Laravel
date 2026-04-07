<?php

namespace App\Filament\Pages;

use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Page;

class ReportSummary extends Page
{
    protected static string |\BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string |\UnitEnum | null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 1;

    public string $startDate;

    public string $endDate;

    protected string $view = 'filament.pages.report-summary';

    public function mount(): void
    {
        $this->startDate = request('start_date', now()->startOfMonth()->toDateString());
        $this->endDate = request('end_date', now()->endOfMonth()->toDateString());
    }

    public function getSummaryProperty(): array
    {
        $rentals = Rental::query()
            ->whereBetween('start_date', [$this->startDate, $this->endDate])
            ->get();

        $gross = (float) $rentals->sum('total_rent_price');
        $late = (float) $rentals->sum('late_fee');
        $additional = (float) $rentals->sum('additional_fee');

        return [
            'transactions' => $rentals->count(),
            'gross' => $gross,
            'late' => $late,
            'net' => $gross + $late + $additional,
        ];
    }

    public function getTopMotorcyclesProperty()
    {
        return Rental::query()
            ->select('motorcycle_id', DB::raw('count(*) as total'))
            ->with('motorcycle:id,name')
            ->whereBetween('start_date', [$this->startDate, $this->endDate])
            ->groupBy('motorcycle_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }
}
