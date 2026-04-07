<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Testimonials';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'customer_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('John Doe'),
                
                FileUpload::make('customer_photo')
                    ->label('Customer Photo')
                    ->image()
                    ->maxSize(1024)
                    ->disk('public')
                    ->directory('testimonials')
                    ->imageEditor()
                    ->circleCropper()
                    ->helperText('Optional: Upload customer photo (max 1MB)'),
                
                Select::make('rating')
                    ->label('Rating')
                    ->options([
                        5 => '⭐⭐⭐⭐⭐ (5 stars)',
                        4 => '⭐⭐⭐⭐ (4 stars)',
                        3 => '⭐⭐⭐ (3 stars)',
                        2 => '⭐⭐ (2 stars)',
                        1 => '⭐ (1 star)',
                    ])
                    ->required()
                    ->default(5),
                
                Textarea::make('review_text')
                    ->label('Review Text')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000)
                    ->placeholder('The service was excellent...')
                    ->columnSpanFull(),
                
                Toggle::make('is_approved')
                    ->label('Approved for Display')
                    ->helperText('Only approved testimonials will be shown on the public website')
                    ->default(false)
                    ->inline(false),
                
                TextInput::make('display_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first (0 = highest priority)')
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('customer_photo')
                    ->label('Photo')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                    ->sortable(),
                
                TextColumn::make('review_text')
                    ->label('Review')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                
                ToggleColumn::make('is_approved')
                    ->label('Approved')
                    ->sortable(),
                
                TextColumn::make('display_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('display_order', 'asc')
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->placeholder('All testimonials')
                    ->trueLabel('Approved only')
                    ->falseLabel('Pending only'),
                
                SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Star',
                    ]),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_approved' => true]);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    
                    \Filament\Actions\BulkAction::make('unapprove')
                        ->label('Unapprove Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['is_approved' => false]);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),
                    
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('display_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_approved', false)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendingCount = static::getModel()::where('is_approved', false)->count();
        return $pendingCount > 0 ? 'warning' : 'success';
    }
}
