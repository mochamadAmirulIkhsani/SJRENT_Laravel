<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AvailabilityFullCalendarWidget;
use Filament\Pages\Page;

class AvailabilityCalendar extends Page
{
    protected static string |\BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string |\UnitEnum | null $navigationGroup = 'Operasional';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.availability-calendar';

    protected function getHeaderWidgets(): array
    {
        return [
            AvailabilityFullCalendarWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
}
