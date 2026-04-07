<?php

namespace App\Filament\Resources\CompanySettings;

use App\Filament\Resources\CompanySettings\Pages\EditCompanySetting;
use App\Models\CompanySetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CompanySettingResource extends Resource
{
    protected static ?string $model = CompanySetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Company Settings';

    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Company Settings')
                    ->tabs([
                        Tabs\Tab::make('Company Information')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                TextInput::make('company_name')
                                    ->label('Company Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('tagline')
                                    ->label('Tagline')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                RichEditor::make('description')
                                    ->label('Description')
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                    ]),
                                FileUpload::make('logo')
                                    ->label('Company Logo')
                                    ->image()
                                    ->maxSize(2048)
                                    ->disk('public')
                                    ->directory('company')
                                    ->imageEditor()
                                    ->columnSpan(1),
                                FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->maxSize(1024)
                                    ->disk('public')
                                    ->directory('company')
                                    ->helperText('Small icon for browser tab (recommended: 32x32 or 64x64)')
                                    ->columnSpan(1),
                            ]),
                        
                        Tabs\Tab::make('Contact Details')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->prefix('+62')
                                    ->placeholder('812-3456-7890'),
                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->placeholder('info@sjrent.com'),
                                TextInput::make('whatsapp')
                                    ->label('WhatsApp Number')
                                    ->tel()
                                    ->prefix('+62')
                                    ->helperText('Used for WhatsApp call-to-action buttons')
                                    ->placeholder('812-3456-7890'),
                                Textarea::make('address')
                                    ->label('Business Address')
                                    ->rows(3)
                                    ->columnSpanFull()
                                    ->placeholder('Jl. Contoh No. 123, Malang, Jawa Timur'),
                                TextInput::make('coordinates_lat')
                                    ->label('Latitude')
                                    ->numeric()
                                    ->step('any')
                                    ->helperText('For Google Maps integration')
                                    ->placeholder('-7.9666'),
                                TextInput::make('coordinates_lng')
                                    ->label('Longitude')
                                    ->numeric()
                                    ->step('any')
                                    ->helperText('For Google Maps integration')
                                    ->placeholder('112.6326'),
                            ]),
                        
                        Tabs\Tab::make('Business Hours')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Repeater::make('business_hours')
                                    ->label('Operating Hours')
                                    ->schema([
                                        Select::make('day')
                                            ->label('Day')
                                            ->options([
                                                'senin' => 'Senin',
                                                'selasa' => 'Selasa',
                                                'rabu' => 'Rabu',
                                                'kamis' => 'Kamis',
                                                'jumat' => 'Jumat',
                                                'sabtu' => 'Sabtu',
                                                'minggu' => 'Minggu',
                                            ])
                                            ->required()
                                            ->columnSpan(1),
                                        TextInput::make('hours')
                                            ->label('Hours')
                                            ->placeholder('08:00 - 17:00')
                                            ->required()
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(7)
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                KeyValue::make('social_media')
                                    ->label('Social Media Links')
                                    ->keyLabel('Platform')
                                    ->valueLabel('URL')
                                    ->addButtonLabel('Add social media')
                                    ->helperText('Add your social media profile URLs (e.g., instagram, facebook, tiktok)')
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('SEO Settings')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(60)
                                    ->helperText('Recommended: 50-60 characters. Used in <title> tag')
                                    ->placeholder('SJRent - Rental Motor Malang Terpercaya')
                                    ->columnSpanFull(),
                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->maxLength(160)
                                    ->helperText('Recommended: 150-160 characters. Appears in search results')
                                    ->placeholder('Rental motor murah dan terpercaya di Malang...')
                                    ->columnSpanFull(),
                                Textarea::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->rows(2)
                                    ->helperText('Comma-separated keywords for SEO')
                                    ->placeholder('rental motor malang, sewa motor malang, motor matic malang')
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('Why Choose Us')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Repeater::make('why_choose_us')
                                    ->label('Benefits & Features')
                                    ->schema([
                                        Select::make('icon')
                                            ->label('Icon')
                                            ->options([
                                                'shield-check' => 'Shield Check (Security)',
                                                'currency-dollar' => 'Currency Dollar (Pricing)',
                                                'clock' => 'Clock (Time/Speed)',
                                                'check-circle' => 'Check Circle (Quality)',
                                                'star' => 'Star (Excellence)',
                                                'wrench-screwdriver' => 'Wrench (Maintenance)',
                                            ])
                                            ->required(),
                                        TextInput::make('title')
                                            ->label('Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Harga Terjangkau'),
                                        Textarea::make('description')
                                            ->label('Description')
                                            ->rows(2)
                                            ->placeholder('Harga rental yang kompetitif dan terjangkau'),
                                    ])
                                    ->columns(1)
                                    ->defaultItems(4)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->columnSpanFull(),
                            ]),
                        
                        Tabs\Tab::make('FAQs')
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                Repeater::make('faqs')
                                    ->label('Frequently Asked Questions')
                                    ->schema([
                                        TextInput::make('question')
                                            ->label('Question')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Bagaimana cara booking motor?'),
                                        Textarea::make('answer')
                                            ->label('Answer')
                                            ->required()
                                            ->rows(3)
                                            ->placeholder('Anda bisa booking melalui WhatsApp atau langsung datang ke kantor kami...'),
                                    ])
                                    ->columns(1)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'edit' => EditCompanySetting::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function canDelete($record): bool
    {
        return false;
    }
}
