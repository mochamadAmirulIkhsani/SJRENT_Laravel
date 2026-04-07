<?php

namespace App\Filament\Widgets;

use App\Models\MotorAvailabilityOverride;
use App\Models\Motorcycle;
use App\Models\Rental;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class AvailabilityFullCalendarWidget extends FullCalendarWidget
{
    public ?int $motorcycleId = null;

    protected ?string $heading = 'Kalender Ketersediaan Motor';

    protected ?string $pollingInterval = null;

    protected function headerActions(): array
    {
        return [
            Action::make('filterMotorcycle')
                ->label('Filter Motor')
                ->form([
                    Select::make('motorcycle_id')
                        ->label('Motor')
                        ->options(Motorcycle::query()->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->placeholder('Semua Motor')
                        ->default($this->motorcycleId),
                ])
                ->action(function (array $data): void {
                    $this->motorcycleId = filled($data['motorcycle_id'] ?? null) ? (int) $data['motorcycle_id'] : null;
                    $this->refreshRecords();
                }),
            Action::make('resetFilter')
                ->label('Reset')
                ->color('gray')
                ->action(function (): void {
                    $this->motorcycleId = null;
                    $this->refreshRecords();
                }),
        ];
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'height' => 'auto',
            'dayMaxEvents' => true,
            'weekends' => true,
        ];
    }

    public function fetchEvents(array $info): array
    {
        $start = Carbon::parse($info['start'])->startOfDay();
        $end = Carbon::parse($info['end'])->endOfDay();

        $rentalQuery = Rental::query()
            ->with(['motorcycle'])
            ->where('status', Rental::STATUS_ONGOING)
            ->whereDate('start_date', '<=', $end->toDateString())
            ->whereDate('estimated_return_date', '>=', $start->toDateString());

        $maintenanceQuery = MotorAvailabilityOverride::query()
            ->with('motorcycle')
            ->where('status', MotorAvailabilityOverride::STATUS_MAINTENANCE)
            ->whereDate('date', '>=', $start->toDateString())
            ->whereDate('date', '<=', $end->toDateString());

        if ($this->motorcycleId) {
            $rentalQuery->where('motorcycle_id', $this->motorcycleId);
            $maintenanceQuery->where('motorcycle_id', $this->motorcycleId);
        }

        $rentalEvents = $rentalQuery
            ->get()
            ->map(function (Rental $rental): array {
                return [
                    'id' => 'rental-' . $rental->id,
                    'title' => 'Disewa - ' . ($rental->motorcycle?->name ?? 'Motor'),
                    'start' => $rental->start_date?->toDateString(),
                    'end' => $rental->estimated_return_date?->copy()->addDay()->toDateString(),
                    'allDay' => true,
                    'backgroundColor' => '#fecaca',
                    'borderColor' => '#dc2626',
                    'textColor' => '#7f1d1d',
                    'url' => route('filament.admin.resources.rentals.edit', ['record' => $rental->id]),
                    'shouldOpenUrlInNewTab' => false,
                ];
            })
            ->all();

        $maintenanceEvents = $maintenanceQuery
            ->get()
            ->map(function (MotorAvailabilityOverride $override): array {
                return [
                    'id' => 'maintenance-' . $override->id,
                    'title' => 'Maintenance - ' . ($override->motorcycle?->name ?? 'Motor'),
                    'start' => $override->date?->toDateString(),
                    'end' => $override->date?->copy()->addDay()->toDateString(),
                    'allDay' => true,
                    'backgroundColor' => '#e5e7eb',
                    'borderColor' => '#6b7280',
                    'textColor' => '#1f2937',
                ];
            })
            ->all();

        return array_merge($rentalEvents, $maintenanceEvents);
    }

    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        $date = Carbon::parse($start)->toDateString();

        $this->redirect(route('filament.admin.resources.rentals.create', [
            'start_date' => $date,
            'estimated_return_date' => $date,
            'motorcycle_id' => $this->motorcycleId,
        ]), navigate: true);
    }

    public function onEventClick(array $event): void
    {
        $url = $event['url'] ?? null;

        if ($url) {
            $this->redirect($url, navigate: true);
        }
    }
}
