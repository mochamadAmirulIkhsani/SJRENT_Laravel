<?php

namespace App\Filament\Resources\RentalResource\RelationManagers;

use App\Models\RentalPayment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pembayaran';

    protected static string |\BackedEnum | null $icon = 'heroicon-o-credit-card';

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('payment_type')
                ->options([
                    RentalPayment::TYPE_RENT_DOWN_PAYMENT => 'DP Sewa',
                    RentalPayment::TYPE_RENT_FULL => 'Pelunasan Sewa',
                    RentalPayment::TYPE_LATE_FEE => 'Denda Keterlambatan',
                    RentalPayment::TYPE_ADDITIONAL_FEE => 'Biaya Tambahan',
                ])
                ->required(),
            TextInput::make('amount')->numeric()->prefix('Rp')->required(),
            DateTimePicker::make('payment_date')->default(now())->required(),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        RentalPayment::TYPE_RENT_DOWN_PAYMENT => 'DP Sewa',
                        RentalPayment::TYPE_RENT_FULL => 'Pelunasan Sewa',
                        RentalPayment::TYPE_LATE_FEE => 'Denda Keterlambatan',
                        default => 'Biaya Tambahan',
                    }),
                TextColumn::make('amount')->money('IDR', true)->summarize(\Filament\Tables\Columns\Summarizers\Sum::make()->label('Total')),
                TextColumn::make('payment_date')->dateTime('d M Y H:i')->sortable(),
                TextColumn::make('notes')->limit(50),
            ])
            ->defaultSort('payment_date', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
