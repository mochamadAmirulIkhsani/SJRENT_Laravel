<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotorcycleResource\Pages;
use App\Models\Motorcycle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MotorcycleResource extends Resource
{
    protected static ?string $model = Motorcycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Layout plan:
                // Tab 1 Overview: edit summary + two-column sections (identity and operational status)
                // Tab 2 Pricing: two-column sections for rental pricing and late fee policy
                // Tab 3 Media: collapsible image section as secondary content
                Tabs::make('MotorcycleForm')
                    ->tabs([
                        Tabs\Tab::make('Overview')
                            ->schema([
                                Placeholder::make('record_summary')
                                    ->label('Ringkasan')
                                    ->content(fn (?Motorcycle $record): ?string => $record
                                        ? "{$record->name} ({$record->plate_number}) | Status: {$record->status}"
                                        : null)
                                    ->hiddenOn('create'),
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Identitas Motor')
                                            ->schema([
                                                TextInput::make('name')->required()->maxLength(255),
                                                TextInput::make('plate_number')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(ignoreRecord: true),
                                                Select::make('category_id')
                                                    ->label('Kategori')
                                                    ->relationship('category', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                            ]),
                                        Section::make('Status Operasional')
                                            ->schema([
                                                Select::make('status')
                                                    ->options([
                                                        Motorcycle::STATUS_AVAILABLE => 'Tersedia',
                                                        Motorcycle::STATUS_RENTED => 'Disewa',
                                                        Motorcycle::STATUS_MAINTENANCE => 'Maintenance',
                                                    ])
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Pricing')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Harga Sewa')
                                            ->schema([
                                                TextInput::make('price_per_day')->numeric()->prefix('Rp')->required(),
                                            ]),
                                        Section::make('Denda Keterlambatan')
                                            ->schema([
                                                TextInput::make('late_fee_per_day')->numeric()->prefix('Rp')->required(),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Media')
                            ->schema([
                                Section::make('Foto Motor')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        FileUpload::make('image')
                                            ->image()
                                            ->directory('motorcycles')
                                            ->disk('public'),
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
                ImageColumn::make('image')->disk('public')->circular(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Kategori')->sortable(),
                TextColumn::make('plate_number')->label('Plat')->searchable(),
                TextColumn::make('price_per_day')->money('IDR', true)->label('Harga/Hari'),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => Motorcycle::STATUS_AVAILABLE,
                        'danger' => Motorcycle::STATUS_RENTED,
                        'gray' => Motorcycle::STATUS_MAINTENANCE,
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Motorcycle::STATUS_AVAILABLE => 'Tersedia',
                        Motorcycle::STATUS_RENTED => 'Disewa',
                        default => 'Maintenance',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        Motorcycle::STATUS_AVAILABLE => 'Tersedia',
                        Motorcycle::STATUS_RENTED => 'Disewa',
                        Motorcycle::STATUS_MAINTENANCE => 'Maintenance',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (): bool => auth()->user()?->hasRole('super_admin') ?? false)
                    ->before(function (Motorcycle $record): void {
                        if ($record->rentals()->where('status', 'ongoing')->exists()) {
                            throw new \Exception('Motor tidak bisa dihapus karena memiliki transaksi aktif.');
                        }
                    }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMotorcycles::route('/'),
            'create' => Pages\CreateMotorcycle::route('/create'),
            'edit' => Pages\EditMotorcycle::route('/{record}/edit'),
        ];
    }
}
