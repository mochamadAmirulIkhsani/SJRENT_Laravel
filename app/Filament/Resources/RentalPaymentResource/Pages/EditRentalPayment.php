<?php

namespace App\Filament\Resources\RentalPaymentResource\Pages;

use App\Filament\Resources\RentalPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalPayment extends EditRecord
{
    protected static string $resource = RentalPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
