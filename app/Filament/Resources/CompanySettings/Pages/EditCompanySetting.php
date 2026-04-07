<?php

namespace App\Filament\Resources\CompanySettings\Pages;

use App\Filament\Resources\CompanySettings\CompanySettingResource;
use App\Models\CompanySetting;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCompanySetting extends EditRecord
{
    protected static string $resource = CompanySettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the singleton instance
        $instance = CompanySetting::getInstance();
        return $instance->toArray();
    }
    
    protected function getRedirectUrl(): ?string
    {
        // Stay on the same page after saving
        return null;
    }
    
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Company settings updated')
            ->body('The company settings have been saved successfully.');
    }
}
