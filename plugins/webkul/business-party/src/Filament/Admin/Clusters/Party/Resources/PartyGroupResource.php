<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource\Pages\CreatePartyGroup;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource\Pages\EditPartyGroup;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource\Pages\ListPartyGroups;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource\Pages\ViewPartyGroup;
use Webkul\BusinessParty\Models\PartyGroup;

class PartyGroupResource extends Resource
{
    protected static ?string $model = PartyGroup::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'group_name';

    public static function getNavigationLabel(): string
    {
        return 'Party Group Master';
    }

    public static function getModelLabel(): string
    {
        return 'Party Group Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Group Master')
                    ->schema([
                        TextInput::make('group_name')
                            ->label('Group Name')
                            ->maxLength(100)
                            ->required(),
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
                TextColumn::make('group_name')->label('Group Name')->searchable()->sortable(),
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
                Section::make('Party Group Master')
                    ->schema([
                        TextEntry::make('group_name')->label('Group Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPartyGroups::route('/'),
            'create' => CreatePartyGroup::route('/create'),
            'view'   => ViewPartyGroup::route('/{record}'),
            'edit'   => EditPartyGroup::route('/{record}/edit'),
        ];
    }
}
