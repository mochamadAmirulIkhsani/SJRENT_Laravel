<?php

namespace App\Filament\Resources\MotorcycleResource\Pages;

use App\Filament\Resources\MotorcycleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMotorcycle extends CreateRecord
{
    protected static string $resource = MotorcycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(MotorcycleResource::getUrl('index')),
        ];
    }
}
