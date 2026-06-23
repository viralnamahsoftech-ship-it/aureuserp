<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources;

use BackedEnum;
use Closure;
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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomMasterResource\Pages\CreateBomMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomMasterResource\Pages\EditBomMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomMasterResource\Pages\ListBomMasters;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomMasterResource\Pages\ViewBomMaster;
use Webkul\BusinessParty\Models\BomMaster;
use Webkul\Support\Filament\Forms\Components\Repeater;
use Webkul\Support\Filament\Forms\Components\Repeater\TableColumn as RepeaterTableColumn;

class BomMasterResource extends Resource
{
    protected static ?string $model = BomMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = ProductionMaster::class;

    protected static ?string $recordTitleAttribute = 'bom_name';

    public static function getNavigationLabel(): string
    {
        return 'BOM Master';
    }

    public static function getModelLabel(): string
    {
        return 'BOM Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('BOM Master')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'branch_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('item_id')
                            ->label('Item')
                            ->relationship('item', 'item_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('bom_code')
                            ->label('BOM Code')
                            ->maxLength(30),
                        TextInput::make('bom_name')
                            ->label('BOM Name')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('revision')
                            ->label('Revision')
                            ->maxLength(20),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
                Section::make('BOM Lines')
                    ->schema([
                        Repeater::make('bomLines')
                            ->hiddenLabel()
                            ->relationship('bomLines')
                            ->defaultItems(0)
                            ->compact()
                            ->addActionLabel('Add Component')
                            ->table([
                                RepeaterTableColumn::make('component_id')->label('Component')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('qty')->label('Qty')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('uom_id')->label('UOM')->resizable(),
                                RepeaterTableColumn::make('process_id')->label('Process')->resizable(),
                                RepeaterTableColumn::make('sort_order')->label('Sort')->resizable(),
                            ])
                            ->schema([
                                Select::make('component_id')
                                    ->label('Component')
                                    ->relationship('component', 'item_name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required()
                                    ->rule(fn (Get $get): Closure => function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                                        if (filled($value) && (int) $value === (int) $get('../../item_id')) {
                                            $fail('Component item cannot be the same as the BOM item.');
                                        }
                                    }),
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
                                    ->default(1)
                                    ->required(),
                                Select::make('uom_id')
                                    ->label('UOM')
                                    ->relationship('uom', 'uom_desc')
                                    ->searchable()
                                    ->preload()
                                    ->native(false),
                                TextInput::make('sort_order')
                                    ->label('Sort')
                                    ->integer()
                                    ->minValue(0)
                                    ->default(0),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bom_code')->label('BOM Code')->searchable()->sortable(),
                TextColumn::make('bom_name')->label('BOM Name')->searchable()->sortable(),
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
                Section::make('BOM Master')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('item_id')->label('Item')->placeholder('-'),
                        TextEntry::make('bom_code')->label('BOM Code')->placeholder('-'),
                        TextEntry::make('bom_name')->label('BOM Name')->placeholder('-'),
                        TextEntry::make('revision')->label('Revision')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBomMasters::route('/'),
            'create' => CreateBomMaster::route('/create'),
            'view'   => ViewBomMaster::route('/{record}'),
            'edit'   => EditBomMaster::route('/{record}/edit'),
        ];
    }
}
