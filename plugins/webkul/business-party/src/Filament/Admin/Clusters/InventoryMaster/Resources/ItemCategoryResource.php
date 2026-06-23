<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources;

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
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource\Pages\CreateItemCategory;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource\Pages\EditItemCategory;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource\Pages\ListItemCategorys;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource\Pages\ViewItemCategory;
use Webkul\BusinessParty\Models\ItemCategory;

class ItemCategoryResource extends Resource
{
    protected static ?string $model = ItemCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = InventoryMaster::class;

    protected static ?string $recordTitleAttribute = 'category_name';

    public static function getNavigationLabel(): string
    {
        return 'Category';
    }

    public static function getModelLabel(): string
    {
        return 'Category';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category')
                    ->schema([
                        TextInput::make('category_name')
                            ->label('Category')
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
                TextColumn::make('category_name')->label('Category')->searchable()->sortable(),
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
                Section::make('Category')
                    ->schema([
                        TextEntry::make('category_name')->label('Category')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListItemCategorys::route('/'),
            'create' => CreateItemCategory::route('/create'),
            'view'   => ViewItemCategory::route('/{record}'),
            'edit'   => EditItemCategory::route('/{record}/edit'),
        ];
    }
}
