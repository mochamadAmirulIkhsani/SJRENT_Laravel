<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('category')
                    ->options(['company' => 'Company', 'fleet' => 'Fleet', 'facilities' => 'Facilities'])
                    ->default('company')
                    ->required(),
                FileUpload::make('image_path')
                    ->image()
                    ->required(),
                TextInput::make('alt_text'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('display_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
