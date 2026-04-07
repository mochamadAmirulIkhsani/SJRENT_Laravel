<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalResource\Pages;
use App\Models\Motorcycle;
use App\Models\Rental;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Operasional';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Layout plan:
                // Tab 1 Overview: edit summary + two-column sections for participants and status
                // Tab 2 Period & Pricing: two-column sections for schedule and cost simulation
                // Tab 3 Settlement: collapsible return-result section for secondary edit data
                Tabs::make('RentalForm')
                    ->tabs([
                        Tabs\Tab::make('Overview')
                            ->schema([
                                Placeholder::make('record_summary')
                                    ->label('Ringkasan')
                                    ->content(fn (?Rental $record): ?string => $record
                                        ? "Rental #{$record->id} | {$record->customer?->name} - {$record->motorcycle?->name}"
                                        : null)
                                    ->hiddenOn('create'),
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Pihak Transaksi')
                                            ->schema([
                                                Select::make('customer_id')
                                                    ->relationship('customer', 'name')
                                                    ->label('Pelanggan')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                Select::make('motorcycle_id')
                                                    ->label('Motor')
                                                    ->options(fn () => Motorcycle::query()->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->required()
                                                    ->live(),
                                            ]),
                                        Section::make('Status')
                                            ->schema([
                                                Select::make('status')
                                                    ->options([
                                                        Rental::STATUS_ONGOING => 'Berlangsung',
                                                        Rental::STATUS_COMPLETED => 'Selesai',
                                                        Rental::STATUS_CANCELLED => 'Dibatalkan',
                                                    ])
                                                    ->default(Rental::STATUS_ONGOING)
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Period & Pricing')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Periode Sewa')
                                            ->schema([
                                                DatePicker::make('start_date')
                                                    ->default(now())
                                                    ->required()
                                                    ->live(),
                                                DatePicker::make('estimated_return_date')
                                                    ->required()
                                                    ->afterOrEqual('start_date')
                                                    ->live(),
                                            ]),
                                        Section::make('Biaya')
                                            ->schema([
                                                TextInput::make('additional_fee')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('Rp')
                                                    ->live(),
                                                Placeholder::make('calculated_summary')
                                                    ->label('Estimasi Biaya')
                                                    ->content(function (Get $get): string {
                                                        $motorId = (int) $get('motorcycle_id');
                                                        $start = $get('start_date');
                                                        $end = $get('estimated_return_date');

                                                        if (!$motorId || !$start || !$end) {
                                                            return 'Pilih motor dan tanggal sewa untuk melihat estimasi biaya.';
                                                        }

                                                        $motorcycle = Motorcycle::query()->find($motorId);
                                                        if (!$motorcycle) {
                                                            return 'Motor tidak ditemukan.';
                                                        }

                                                        $days = max(1, Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1);
                                                        $total = $days * (float) $motorcycle->price_per_day;

                                                        return "Durasi {$days} hari | Estimasi total: Rp " . number_format($total, 0, ',', '.');
                                                    }),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Settlement')
                            ->schema([
                                Section::make('Hasil Pengembalian')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                DatePicker::make('actual_return_date')->disabled()->dehydrated(false),
                                                TextInput::make('late_days')->numeric()->disabled()->dehydrated(false),
                                                TextInput::make('late_fee')->prefix('Rp')->disabled()->dehydrated(false),
                                                TextInput::make('grand_total')->prefix('Rp')->disabled()->dehydrated(false),
                                            ]),
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
                TextColumn::make('customer.name')->label('Pelanggan')->searchable()->sortable(),
                TextColumn::make('motorcycle.name')->label('Motor')->searchable()->sortable(),
                TextColumn::make('period')
                    ->label('Periode')
                    ->state(fn (Rental $record): string => $record->start_date?->format('d M') . ' - ' . $record->estimated_return_date?->format('d M Y')),
                TextColumn::make('grand_total')->money('IDR', true)->label('Grand Total')->summarize(Sum::make()->label('Total')),
                TextColumn::make('late_fee')->money('IDR', true)->label('Denda')->summarize(Sum::make()->label('Total denda')),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => Rental::STATUS_ONGOING,
                        'success' => Rental::STATUS_COMPLETED,
                        'gray' => Rental::STATUS_CANCELLED,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Rental::STATUS_ONGOING => 'Berlangsung',
                        Rental::STATUS_COMPLETED => 'Selesai',
                        default => 'Dibatalkan',
                    }),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Rental::STATUS_ONGOING => 'Berlangsung',
                        Rental::STATUS_COMPLETED => 'Selesai',
                        Rental::STATUS_CANCELLED => 'Dibatalkan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('return_motorcycle')
                    ->label('Kembalikan Motor')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (Rental $record): bool => $record->status === Rental::STATUS_ONGOING)
                    ->form([
                        DatePicker::make('actual_return_date')->default(now())->required(),
                        TextInput::make('additional_fee')->numeric()->default(0)->prefix('Rp'),
                    ])
                    ->action(function (Rental $record, array $data): void {
                        $record->processReturn(
                            Carbon::parse($data['actual_return_date']),
                            (float) ($data['additional_fee'] ?? 0),
                        );
                    }),
                Tables\Actions\Action::make('invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Rental $record): string => route('rentals.invoice', $record))
                    ->openUrlInNewTab(),
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
            \App\Filament\Resources\RentalResource\RelationManagers\RentalPaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentals::route('/'),
            'create' => Pages\CreateRental::route('/create'),
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }
}
