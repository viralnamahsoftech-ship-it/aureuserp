<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomLineResource\Pages\CreateBomLine;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomLineResource\Pages\EditBomLine;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomLineResource\Pages\ListBomLines;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomLineResource\Pages\ViewBomLine;
use Webkul\BusinessParty\Models\BomLine;

class BomLineResource extends Resource
{
    protected static ?string $model = BomLine::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = ProductionMaster::class;

    protected static ?string $recordTitleAttribute = 'id';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'BOM Line';
    }

    public static function getModelLabel(): string
    {
        return 'BOM Line';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('BOM Line')
                    ->schema([
                        Select::make('bom_id')
                            ->label('BOM')
                            ->relationship('bom', 'bom_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('component_id')
                            ->label('Component Item')
                            ->relationship('component', 'item_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('process_id')
                            ->label('Process')
                            ->relationship('process', 'process_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('qty')
                            ->label('Qty')
                            ->numeric()
                            ->minValue(0.0001)
                            ->step(0.0001)
                            ->default(1),
                        Select::make('uom_id')
                            ->label('UOM')
                            ->relationship('uom', 'uom_desc')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->integer()
                            ->minValue(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('qty')->label('Qty')->searchable()->sortable(),
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
                Section::make('BOM Line')
                    ->schema([
                        TextEntry::make('bom_id')->label('BOM')->placeholder('-'),
                        TextEntry::make('component_id')->label('Component Item')->placeholder('-'),
                        TextEntry::make('process_id')->label('Process')->placeholder('-'),
                        TextEntry::make('qty')->label('Qty')->placeholder('-'),
                        TextEntry::make('uom_id')->label('UOM')->placeholder('-'),
                        TextEntry::make('sort_order')->label('Sort Order')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBomLines::route('/'),
            'create' => CreateBomLine::route('/create'),
            'view'   => ViewBomLine::route('/{record}'),
            'edit'   => EditBomLine::route('/{record}/edit'),
        ];
    }
}
