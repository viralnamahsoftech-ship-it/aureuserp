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
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\UomResource\Pages\CreateUom;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\UomResource\Pages\EditUom;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\UomResource\Pages\ListUoms;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\UomResource\Pages\ViewUom;
use Webkul\BusinessParty\Models\Uom;

class UomResource extends Resource
{
    protected static ?string $model = Uom::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    protected static ?string $cluster = InventoryMaster::class;

    protected static ?string $recordTitleAttribute = 'uom_desc';

    public static function getNavigationLabel(): string
    {
        return 'UOM';
    }

    public static function getModelLabel(): string
    {
        return 'UOM';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('UOM')
                    ->schema([
                        TextInput::make('uom_desc')
                            ->label('UOM Desc')
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
                TextColumn::make('uom_desc')->label('UOM Desc')->searchable()->sortable(),
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
                Section::make('UOM')
                    ->schema([
                        TextEntry::make('uom_desc')->label('UOM Desc')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListUoms::route('/'),
            'create' => CreateUom::route('/create'),
            'view'   => ViewUom::route('/{record}'),
            'edit'   => EditUom::route('/{record}/edit'),
        ];
    }
}
