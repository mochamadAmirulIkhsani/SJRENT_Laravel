<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_photo'),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(5),
                Textarea::make('review_text')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_approved')
                    ->required(),
                TextInput::make('display_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
