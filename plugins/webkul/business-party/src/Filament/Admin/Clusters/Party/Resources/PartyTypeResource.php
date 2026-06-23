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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource\Pages\CreatePartyType;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource\Pages\EditPartyType;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource\Pages\ListPartyTypes;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource\Pages\ViewPartyType;
use Webkul\BusinessParty\Models\PartyType;

class PartyTypeResource extends Resource
{
    protected static ?string $model = PartyType::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'ptype';

    public static function getNavigationLabel(): string
    {
        return 'Party Type';
    }

    public static function getModelLabel(): string
    {
        return 'Party Type';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Type')
                    ->schema([
                        Select::make('ptype')
                            ->label('Party Type')
                            ->options([
                                'Supplier' => 'Supplier',
                                'Customer' => 'Customer',
                                'Vendor'   => 'Vendor',
                                'General'  => 'General',
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('pstype')
                            ->label('Party Sub Type')
                            ->maxLength(100),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ptype')->label('Party Type')->searchable()->sortable(),
                TextColumn::make('pstype')->label('Party Sub Type')->searchable()->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean()->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Active'),
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
                Section::make('Party Type')
                    ->schema([
                        TextEntry::make('ptype')->label('Party Type')->placeholder('-'),
                        TextEntry::make('pstype')->label('Party Sub Type')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPartyTypes::route('/'),
            'create' => CreatePartyType::route('/create'),
            'view'   => ViewPartyType::route('/{record}'),
            'edit'   => EditPartyType::route('/{record}/edit'),
        ];
    }
}
