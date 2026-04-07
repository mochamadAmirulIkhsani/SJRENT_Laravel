<?php

namespace App\Filament\Resources\Galleries;

use App\Filament\Resources\Galleries\Pages\CreateGallery;
use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\Pages\ListGalleries;
use App\Models\Gallery;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Gallery';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Photo title')
                    ->columnSpanFull(),
                
                Select::make('category')
                    ->label('Category')
                    ->options([
                        'company' => 'Company',
                        'fleet' => 'Fleet',
                        'facilities' => 'Facilities',
                    ])
                    ->required()
                    ->native(false)
                    ->placeholder('Select category'),
                
                TextInput::make('display_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first')
                    ->minValue(0),
                
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->required()
                    ->maxSize(2048)
                    ->disk('public')
                    ->directory('gallery')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->columnSpanFull(),
                
                TextInput::make('alt_text')
                    ->label('Alt Text')
                    ->maxLength(255)
                    ->helperText('For SEO and accessibility - describe what\'s in the image')
                    ->placeholder('e.g., Honda Beat motorcycle in showroom')
                    ->columnSpanFull(),
                
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->placeholder('Optional description for this image')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->square()
                    ->size(80),
                
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),
                
                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->colors([
                        'primary' => 'company',
                        'success' => 'fleet',
                        'warning' => 'facilities',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                
                TextColumn::make('alt_text')
                    ->label('Alt Text')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('display_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort(fn (Builder $query) => $query->orderBy('category')->orderBy('display_order')->orderBy('created_at', 'desc'))
            ->filters([
                SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        'company' => 'Company',
                        'fleet' => 'Fleet',
                        'facilities' => 'Facilities',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('changeCategory')
                        ->label('Change Category')
                        ->icon('heroicon-o-tag')
                        ->form([
                            Select::make('category')
                                ->label('New Category')
                                ->options([
                                    'company' => 'Company',
                                    'fleet' => 'Fleet',
                                    'facilities' => 'Facilities',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each->update(['category' => $data['category']]);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('display_order')
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
