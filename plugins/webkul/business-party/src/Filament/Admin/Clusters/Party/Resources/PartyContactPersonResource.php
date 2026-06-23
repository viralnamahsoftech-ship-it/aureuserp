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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource\Pages\CreatePartyContactPerson;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource\Pages\EditPartyContactPerson;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource\Pages\ListPartyContactPersons;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource\Pages\ViewPartyContactPerson;
use Webkul\BusinessParty\Models\PartyContactPerson;

class PartyContactPersonResource extends Resource
{
    protected static ?string $model = PartyContactPerson::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'contact_name';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Party Contact Person';
    }

    public static function getModelLabel(): string
    {
        return 'Party Contact Person';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Contact Person')
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
                        TextInput::make('contact_name')
                            ->label('Person Name')
                            ->maxLength(255)
                            ->required(),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'dept_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('designation_id')
                            ->label('Designation')
                            ->relationship('designation', 'designation_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('mobile')
                            ->label('Mobile Number')
                            ->tel()
                            ->rules(['nullable', 'digits:10'])
                            ->maxLength(30),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->maxLength(30),
                        TextInput::make('ext_no')
                            ->label('Extn No')
                            ->maxLength(20),
                        TextInput::make('email')
                            ->label('Email ID')
                            ->email()
                            ->maxLength(255),
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
                TextColumn::make('contact_name')->label('Person Name')->searchable()->sortable(),
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
                Section::make('Party Contact Person')
                    ->schema([
                        TextEntry::make('party_id')->label('Party')->placeholder('-'),
                        TextEntry::make('site_name')->label('Site Name')->placeholder('-'),
                        TextEntry::make('contact_name')->label('Person Name')->placeholder('-'),
                        TextEntry::make('department_id')->label('Department')->placeholder('-'),
                        TextEntry::make('designation_id')->label('Designation')->placeholder('-'),
                        TextEntry::make('mobile')->label('Mobile Number')->placeholder('-'),
                        TextEntry::make('phone')->label('Phone Number')->placeholder('-'),
                        TextEntry::make('ext_no')->label('Extn No')->placeholder('-'),
                        TextEntry::make('email')->label('Email ID')->placeholder('-'),
                        IconEntry::make('is_whatsapp')->label('IS What app Numer')->boolean(),
                        IconEntry::make('auto_mail')->label('Auto mail')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPartyContactPersons::route('/'),
            'create' => CreatePartyContactPerson::route('/create'),
            'view'   => ViewPartyContactPerson::route('/{record}'),
            'edit'   => EditPartyContactPerson::route('/{record}/edit'),
        ];
    }
}
