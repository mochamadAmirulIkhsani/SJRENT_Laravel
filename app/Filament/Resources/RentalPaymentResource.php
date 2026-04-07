<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalPaymentResource\Pages;
use App\Models\RentalPayment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalPaymentResource extends Resource
{
    protected static ?string $model = RentalPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Operasional';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Layout plan:
                // Tab 1 Overview: two-column sections for transaction context and payment detail
                // Tab 2 Notes: collapsible notes section as secondary input
                Tabs::make('PaymentForm')
                    ->tabs([
                        Tabs\Tab::make('Overview')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Transaksi')
                                            ->schema([
                                                Select::make('rental_id')
                                                    ->relationship('rental', 'id')
                                                    ->getOptionLabelFromRecordUsing(fn ($record) => "#{$record->id} - {$record->customer->name}")
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                            ]),
                                        Section::make('Pembayaran')
                                            ->schema([
                                                TextInput::make('amount')->numeric()->required()->prefix('Rp'),
                                                Select::make('payment_type')
                                                    ->options([
                                                        RentalPayment::TYPE_RENT_DOWN_PAYMENT => 'DP Sewa',
                                                        RentalPayment::TYPE_RENT_FULL => 'Pelunasan Sewa',
                                                        RentalPayment::TYPE_LATE_FEE => 'Denda Keterlambatan',
                                                        RentalPayment::TYPE_ADDITIONAL_FEE => 'Biaya Tambahan',
                                                    ])
                                                    ->required(),
                                                DateTimePicker::make('payment_date')->default(now())->required(),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Notes')
                            ->schema([
                                Section::make('Catatan')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Textarea::make('notes')->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rental.id')->label('Transaksi #')->sortable(),
                TextColumn::make('rental.customer.name')->label('Pelanggan')->searchable(),
                TextColumn::make('amount')->money('IDR', true),
                TextColumn::make('payment_type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        RentalPayment::TYPE_RENT_DOWN_PAYMENT => 'DP Sewa',
                        RentalPayment::TYPE_RENT_FULL => 'Pelunasan Sewa',
                        RentalPayment::TYPE_LATE_FEE => 'Denda Keterlambatan',
                        default => 'Biaya Tambahan',
                    }),
                TextColumn::make('payment_date')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalPayments::route('/'),
            'create' => Pages\CreateRentalPayment::route('/create'),
            'edit' => Pages\EditRentalPayment::route('/{record}/edit'),
        ];
    }
}
