<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources;

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
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMainSubGroupResource\Pages\CreateItemMainSubGroup;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMainSubGroupResource\Pages\EditItemMainSubGroup;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMainSubGroupResource\Pages\ListItemMainSubGroups;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMainSubGroupResource\Pages\ViewItemMainSubGroup;
use Webkul\BusinessParty\Models\ItemMainSubGroup;

class ItemMainSubGroupResource extends Resource
{
    protected static ?string $model = ItemMainSubGroup::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = InventoryMaster::class;

    protected static ?string $recordTitleAttribute = 'group_name';

    public static function getNavigationLabel(): string
    {
        return 'Main Sub Group Master';
    }

    public static function getModelLabel(): string
    {
        return 'Main Sub Group Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main Sub Group Master')
                    ->schema([
                        TextInput::make('group_name')
                            ->label('Group Name')
                            ->maxLength(100)
                            ->required(),
                        Select::make('group_type')
                            ->label('Group Type')
                            ->options([
                                'Main'  => 'Main',
                                'Sub'   => 'Sub',
                                'Other' => 'Other',
                            ])
                            ->native(false)
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
                TextColumn::make('group_type')->label('Group Type')->searchable()->sortable(),
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
                Section::make('Main Sub Group Master')
                    ->schema([
                        TextEntry::make('group_name')->label('Group Name')->placeholder('-'),
                        TextEntry::make('group_type')->label('Group Type')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListItemMainSubGroups::route('/'),
            'create' => CreateItemMainSubGroup::route('/create'),
            'view'   => ViewItemMainSubGroup::route('/{record}'),
            'edit'   => EditItemMainSubGroup::route('/{record}/edit'),
        ];
    }
}
