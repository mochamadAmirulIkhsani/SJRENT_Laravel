<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotorcycleResource\Pages;
use App\Models\Motorcycle;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;

class MotorcycleResource extends Resource
{
    protected static ?string $model = Motorcycle::class;

    protected static string |\BackedEnum | null $navigationIcon = 'heroicon-o-truck';

    protected static string |\UnitEnum | null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
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
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, $set, $get) {
                                                        if (empty($get('slug'))) {
                                                            $set('slug', \Illuminate\Support\Str::slug($state));
                                                        }
                                                    }),
                                                TextInput::make('slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(ignoreRecord: true)
                                                    ->helperText('Auto-generated from name, used in URL')
                                                    ->disabled(fn ($operation) => $operation === 'create'),
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
                        Tabs\Tab::make('Features & Specs')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->schema([
                                Section::make('Features')
                                    ->description('Key features of this motorcycle')
                                    ->schema([
                                        \Filament\Forms\Components\TagsInput::make('features')
                                            ->label('Features')
                                            ->placeholder('Add feature (press Enter after each)')
                                            ->helperText('Example: ABS, USB Charger, Large Storage, etc.')
                                            ->separator(',')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Specifications')
                                    ->description('Technical specifications')
                                    ->schema([
                                        \Filament\Forms\Components\KeyValue::make('specifications')
                                            ->label('Specifications')
                                            ->keyLabel('Specification Name')
                                            ->valueLabel('Value')
                                            ->addButtonLabel('Add specification')
                                            ->helperText('Example: Engine Capacity → 125cc, Transmission → Automatic, etc.')
                                            ->columnSpanFull(),
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
                                            ->disk('public')
                                            ->imageEditor(),
                                    ]),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('Search Engine Optimization')
                                    ->description('Improve visibility in search results')
                                    ->schema([
                                        TextInput::make('seo_title')
                                            ->label('SEO Title')
                                            ->maxLength(60)
                                            ->helperText('If empty, uses motorcycle name (recommended: 50-60 characters)')
                                            ->placeholder('Honda Beat 2023 - Rental Motor Malang'),
                                        \Filament\Forms\Components\Textarea::make('seo_description')
                                            ->label('SEO Description')
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Recommended: 150-160 characters')
                                            ->placeholder('Sewa Honda Beat 2023 di Malang dengan harga terjangkau...'),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->stackedOnMobile()
            ->recordActionsPosition(RecordActionsPosition::BeforeCells)
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->circular()
                    ->size(56),
                TextColumn::make('name')
                    ->label('Motor')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copied!')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                TextColumn::make('plate_number')->label('Plat')->searchable(),
                TextColumn::make('price_per_day')
                    ->money('IDR', true)
                    ->label('Harga/Hari'),
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
                    })
                    ->badge(),
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
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (): bool => auth()->user()?->hasRole('super_admin') ?? false)
                    ->before(function (Motorcycle $record): void {
                        if ($record->rentals()->where('status', 'ongoing')->exists()) {
                            throw new \Exception('Motor tidak bisa dihapus karena memiliki transaksi aktif.');
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
            'index' => Pages\ListMotorcycles::route('/'),
            'create' => Pages\CreateMotorcycle::route('/create'),
            'edit' => Pages\EditMotorcycle::route('/{record}/edit'),
        ];
    }
}

