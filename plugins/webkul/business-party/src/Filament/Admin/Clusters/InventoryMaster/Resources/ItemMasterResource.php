<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMasterResource\Pages\CreateItemMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMasterResource\Pages\EditItemMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMasterResource\Pages\ListItemMasters;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMasterResource\Pages\ViewItemMaster;
use Webkul\BusinessParty\Models\ItemMaster;

class ItemMasterResource extends Resource
{
    protected static ?string $model = ItemMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = InventoryMaster::class;

    protected static ?string $recordTitleAttribute = 'item_name';

    public static function getNavigationLabel(): string
    {
        return 'Item Master';
    }

    public static function getModelLabel(): string
    {
        return 'Item Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item Master')
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
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'category_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('item_group_id')
                            ->label('Item Group')
                            ->relationship('itemGroup', 'group_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('item_code')
                            ->label('Item Code')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('Auto Generated')
                            ->maxLength(30),
                        TextInput::make('item_name')
                            ->label('Item Name')
                            ->maxLength(255)
                            ->required(),
                        Select::make('item_type')
                            ->label('Item Type')
                            ->options([
                                'Sales'    => 'Sales',
                                'Purchase' => 'Purchase',
                                'Service'  => 'Service',
                                'General'  => 'General',
                            ])
                            ->native(false)
                            ->required(),
                        Select::make('process_type')
                            ->label('Process Type')
                            ->options([
                                'Procured'    => 'Procured',
                                'Manufacture' => 'Manufactore',
                            ])
                            ->native(false)
                            ->required(),
                        Select::make('uom_id')
                            ->label('UOM')
                            ->relationship('uom', 'uom_desc')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('purch_uom_id')
                            ->label('Purch UOM')
                            ->relationship('purchUom', 'uom_desc')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('sales_uom_id')
                            ->label('Sales UOM')
                            ->relationship('salesUom', 'uom_desc')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('conv_qty')
                            ->label('C Qty')
                            ->numeric()
                            ->minValue(0.0001)
                            ->step(0.0001)
                            ->default(1),
                        TextInput::make('purch_conv_qty')
                            ->label('Purch Conv Qty')
                            ->numeric()
                            ->minValue(0.0001)
                            ->step(0.0001)
                            ->default(1),
                        TextInput::make('sales_conv_qty')
                            ->label('Sales Conv Qty')
                            ->numeric()
                            ->minValue(0.0001)
                            ->step(0.0001)
                            ->default(1),
                        RichEditor::make('detail_desc')
                            ->label('Detail Desc.')
                            ->columnSpanFull(),
                        TextInput::make('drawing_no')
                            ->label('Drawing Number')
                            ->maxLength(100),
                        TextInput::make('drawing_rev_no')
                            ->label('Drawing Rev. No')
                            ->maxLength(100),
                        TextInput::make('part_no')
                            ->label('Part No')
                            ->maxLength(100),
                        Select::make('main_group_id')
                            ->label('Main Group')
                            ->relationship('mainGroup', 'group_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('sub_group_id')
                            ->label('Sub Group')
                            ->relationship('subGroup', 'group_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('other_group_id')
                            ->label('Other Group')
                            ->relationship('otherGroup', 'group_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Toggle::make('qc_required')
                            ->label('QC Req')
                            ->default(false),
                        Toggle::make('qc_param_required')
                            ->label('QC Parameter Req')
                            ->default(false),
                        TextInput::make('location')
                            ->label('Location')
                            ->maxLength(100),
                        Textarea::make('internal_remarks')
                            ->label('Internal Remarks'),
                        TextInput::make('make')
                            ->label('Make')
                            ->maxLength(100),
                        TextInput::make('serial_no_code')
                            ->label('Serial No Code')
                            ->maxLength(100),
                        TextInput::make('min_stock')
                            ->label('Minimum Stock')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('moq')
                            ->label('MOQ')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('lead_time')
                            ->label('Lead Time')
                            ->integer()
                            ->minValue(0),
                        TextInput::make('class_name')
                            ->label('Class Name')
                            ->maxLength(100),
                        Toggle::make('manual_trans')
                            ->label('Manual Trans')
                            ->default(false),
                        TextInput::make('tolerance_plus')
                            ->label('Tollerance (+)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('tolerance_minus')
                            ->label('Tollerance (-)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('max_qty')
                            ->label('Maximum Qty')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('max_order_qty')
                            ->label('Maximum Order Qty')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('reorder_qty')
                            ->label('Reorder Qty')
                            ->numeric()
                            ->minValue(0),
                        Toggle::make('grn_required')
                            ->label('GRN Req')
                            ->default(false),
                        Toggle::make('material_provide')
                            ->label('Material Provide')
                            ->default(false),
                        TextInput::make('size_packet_qty')
                            ->label('Size or Packet Qty')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('self_life')
                            ->label('Self Life')
                            ->integer()
                            ->minValue(0),
                        TextInput::make('warranty_period')
                            ->label('Warranty Period')
                            ->integer()
                            ->minValue(0),
                        Select::make('hsn_id')
                            ->label('HSN Code')
                            ->relationship('hsn', 'hsn_no')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('acct_gl_code')
                            ->label('acctGLcode')
                            ->maxLength(50),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                        Toggle::make('batch_wise')
                            ->label('Batch wise Stock')
                            ->default(false),
                        Toggle::make('serial_no_wise')
                            ->label('Serial Number Wise Stock')
                            ->default(false),
                        Toggle::make('account_effect')
                            ->label('Account Effect')
                            ->default(false),
                        Toggle::make('is_stock_effect')
                            ->label('ISStockefct')
                            ->default(false),
                        Select::make('planning')
                            ->label('Planing')
                            ->options([
                                'Against Order' => 'Against Order',
                                'Cumulative'    => 'Cummilitive',
                                'Both'          => 'Both',
                            ])
                            ->native(false),
                        Select::make('gst_on')
                            ->label('GST On')
                            ->options([
                                'ItemWise'     => 'Itemwise',
                                'InvoiceBased' => 'invoice',
                            ])
                            ->native(false),
                        Select::make('gst_supply_type')
                            ->label('GST Supply Type')
                            ->options([
                                'InterState' => 'InterState',
                                'IntraState' => 'IntraState',
                                'Export'     => 'Export',
                                'Import'     => 'Import',
                            ])
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item_code')->label('Item Code')->searchable()->sortable(),
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
                Section::make('Item Master')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('category_id')->label('Category')->placeholder('-'),
                        TextEntry::make('item_group_id')->label('Item Group')->placeholder('-'),
                        TextEntry::make('item_code')->label('Item Code')->placeholder('-'),
                        TextEntry::make('item_name')->label('Item Name')->placeholder('-'),
                        TextEntry::make('item_type')->label('Item Type')->placeholder('-'),
                        TextEntry::make('process_type')->label('Process Type')->placeholder('-'),
                        TextEntry::make('uom_id')->label('UOM')->placeholder('-'),
                        TextEntry::make('purch_uom_id')->label('Purch UOM')->placeholder('-'),
                        TextEntry::make('sales_uom_id')->label('Sales UOM')->placeholder('-'),
                        TextEntry::make('conv_qty')->label('C Qty')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getApproveAction(): Action
    {
        return Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->visible(fn ($record): bool => blank($record?->approved_by) && auth()->user()?->can('approve_business_party_item_master'))
            ->action(function ($record): void {
                $record->forceFill([
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ])->save();

                Notification::make()
                    ->success()
                    ->title('Approved')
                    ->body('Item Master approved.')
                    ->send();
            });
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListItemMasters::route('/'),
            'create' => CreateItemMaster::route('/create'),
            'view'   => ViewItemMaster::route('/{record}'),
            'edit'   => EditItemMaster::route('/{record}/edit'),
        ];
    }
}
