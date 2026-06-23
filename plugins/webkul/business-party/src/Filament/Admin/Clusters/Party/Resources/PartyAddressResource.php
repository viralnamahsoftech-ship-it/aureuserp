<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource\Pages\CreatePartyAddress;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource\Pages\EditPartyAddress;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource\Pages\ListPartyAddresses;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource\Pages\ViewPartyAddress;
use Webkul\BusinessParty\Models\PartyAddress;

class PartyAddressResource extends Resource
{
    protected static ?string $model = PartyAddress::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'site_name';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Party Address';
    }

    public static function getModelLabel(): string
    {
        return 'Party Address';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Address')
                    ->schema([
                        Select::make('party_id')
                            ->label('Party')
                            ->relationship('party', 'party_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->maxLength(100),
                        Select::make('address_type')
                            ->label('Address Type')
                            ->options([
                                'Billing'  => 'Billing',
                                'Delivery' => 'Delivery',
                                'Both'     => 'Both',
                            ])
                            ->native(false)
                            ->required(),
                        Textarea::make('address')
                            ->label('Address'),
                        Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'city_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('state_id')
                            ->label('State')
                            ->relationship('state', 'state_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('state_code')
                            ->label('State Code')
                            ->maxLength(10),
                        Select::make('country_id')
                            ->label('Country')
                            ->relationship('country', 'country_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('pincode')
                            ->label('Pincode')
                            ->maxLength(20)
                            ->rules(['nullable', 'digits_between:6,10']),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->maxLength(30),
                        TextInput::make('mobile')
                            ->label('Mobile')
                            ->tel()
                            ->rules(['nullable', 'digits:10'])
                            ->maxLength(30),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('gstin')
                            ->label('GSTIN Number')
                            ->maxLength(30)
                            ->rules(['nullable', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'])
                            ->validationMessages(['regex' => 'Invalid GSTIN format. Expected: 22AAAAA0000A1Z5']),
                        Toggle::make('is_whatsapp')
                            ->label('IS What app Numer')
                            ->default(false),
                        Toggle::make('auto_mail')
                            ->label('Auto mail')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_name')->label('Site Name')->searchable()->sortable(),
                TextColumn::make('address_type')->label('Address Type')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])

            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Address')
                    ->schema([
                        TextEntry::make('party_id')->label('Party')->placeholder('-'),
                        TextEntry::make('site_name')->label('Site Name')->placeholder('-'),
                        TextEntry::make('address_type')->label('Address Type')->placeholder('-'),
                        TextEntry::make('address')->label('Address')->placeholder('-'),
                        TextEntry::make('city_id')->label('City')->placeholder('-'),
                        TextEntry::make('state_id')->label('State')->placeholder('-'),
                        TextEntry::make('state_code')->label('State Code')->placeholder('-'),
                        TextEntry::make('country_id')->label('Country')->placeholder('-'),
                        TextEntry::make('pincode')->label('Pincode')->placeholder('-'),
                        TextEntry::make('phone')->label('Phone')->placeholder('-'),
                        TextEntry::make('mobile')->label('Mobile')->placeholder('-'),
                        TextEntry::make('email')->label('Email')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPartyAddresses::route('/'),
            'create' => CreatePartyAddress::route('/create'),
            'view'   => ViewPartyAddress::route('/{record}'),
            'edit'   => EditPartyAddress::route('/{record}/edit'),
        ];
    }
}
