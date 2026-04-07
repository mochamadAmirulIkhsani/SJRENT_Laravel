<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string |\BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static string |\UnitEnum | null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Layout plan:
                // Tab 1 Overview: edit summary + two-column sections for identity and legal documents
                // Tab 2 Contact: contact section + collapsible address section
                Tabs::make('CustomerForm')
                    ->tabs([
                        Tabs\Tab::make('Overview')
                            ->schema([
                                Placeholder::make('record_summary')
                                    ->label('Ringkasan')
                                    ->content(fn (?Customer $record): ?string => $record
                                        ? "{$record->name} | KTP: {$record->id_card_number}"
                                        : null)
                                    ->hiddenOn('create'),
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Identitas')
                                            ->schema([
                                                TextInput::make('name')->required()->maxLength(255),
                                            ]),
                                        Section::make('Dokumen')
                                            ->schema([
                                                TextInput::make('id_card_number')->label('No KTP')->required()->unique(ignoreRecord: true),
                                                TextInput::make('driver_license_number')->label('No SIM')->required()->unique(ignoreRecord: true),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Contact')
                            ->schema([
                                Section::make('Kontak Utama')
                                    ->schema([
                                        TextInput::make('phone')->required(),
                                    ]),
                                Section::make('Alamat')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Textarea::make('address')->rows(3)->columnSpanFull(),
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
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('id_card_number')->label('No KTP')->searchable(),
                TextColumn::make('driver_license_number')->label('No SIM')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('rentals_count')->counts('rentals')->label('Total Sewa'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (): bool => auth()->user()?->hasRole('super_admin') ?? false)
                    ->before(function (Customer $record): void {
                        if ($record->hasActiveRental()) {
                            throw new \Exception('Pelanggan tidak bisa dihapus karena memiliki transaksi aktif.');
                        }
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}

