<?php

namespace App\Filament\Resources\RentalResource\Pages;

use App\Filament\Resources\RentalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRental extends CreateRecord
{
    protected static string $resource = RentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(RentalResource::getUrl('index')),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'start_date' => request('start_date', now()->toDateString()),
            'estimated_return_date' => request('estimated_return_date', now()->toDateString()),
            'motorcycle_id' => request('motorcycle_id'),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
