<?php

namespace App\Filament\Resources\RentalPaymentResource\Pages;

use App\Filament\Resources\RentalPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRentalPayment extends CreateRecord
{
    protected static string $resource = RentalPaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }
}
