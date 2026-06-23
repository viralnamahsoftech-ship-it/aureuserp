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
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\HsnMasterResource\Pages\CreateHsnMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\HsnMasterResource\Pages\EditHsnMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\HsnMasterResource\Pages\ListHsnMasters;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\HsnMasterResource\Pages\ViewHsnMaster;
use Webkul\BusinessParty\Models\HsnMaster;

class HsnMasterResource extends Resource
{
    protected static ?string $model = HsnMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $cluster = InventoryMaster::class;

    protected static ?string $recordTitleAttribute = 'hsn_no';

    public static function getNavigationLabel(): string
    {
        return 'HSN Master';
    }

    public static function getModelLabel(): string
    {
        return 'HSN Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('HSN Master')
                    ->schema([
                        TextInput::make('hsn_no')
                            ->label('HSN No')
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('hsn_desc')
                            ->label('HSN Desc')
                            ->maxLength(255),
                        TextInput::make('sgst')
                            ->label('SGST')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('cgst')
                            ->label('CSGT')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('igst')
                            ->label('IGST')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('psgt_gl')
                            ->label('PSGT GL')
                            ->maxLength(50),
                        TextInput::make('pcgt_gl')
                            ->label('PCGT GL')
                            ->maxLength(50),
                        TextInput::make('pigt_gl')
                            ->label('PIGT GL')
                            ->maxLength(50),
                        TextInput::make('ssgt_gl')
                            ->label('SSGT GL')
                            ->maxLength(50),
                        TextInput::make('scgt_gl')
                            ->label('SCGT GL')
                            ->maxLength(50),
                        TextInput::make('sigt_gl')
                            ->label('SIGT GL')
                            ->maxLength(50),
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
                TextColumn::make('hsn_no')->label('HSN No')->searchable()->sortable(),
                TextColumn::make('hsn_desc')->label('HSN Desc')->searchable()->sortable(),
                TextColumn::make('sgst')->label('SGST')->searchable()->sortable(),
                TextColumn::make('cgst')->label('CSGT')->searchable()->sortable(),
                TextColumn::make('igst')->label('IGST')->searchable()->sortable(),
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
                Section::make('HSN Master')
                    ->schema([
                        TextEntry::make('hsn_no')->label('HSN No')->placeholder('-'),
                        TextEntry::make('hsn_desc')->label('HSN Desc')->placeholder('-'),
                        TextEntry::make('sgst')->label('SGST')->placeholder('-'),
                        TextEntry::make('cgst')->label('CSGT')->placeholder('-'),
                        TextEntry::make('igst')->label('IGST')->placeholder('-'),
                        TextEntry::make('psgt_gl')->label('PSGT GL')->placeholder('-'),
                        TextEntry::make('pcgt_gl')->label('PCGT GL')->placeholder('-'),
                        TextEntry::make('pigt_gl')->label('PIGT GL')->placeholder('-'),
                        TextEntry::make('ssgt_gl')->label('SSGT GL')->placeholder('-'),
                        TextEntry::make('scgt_gl')->label('SCGT GL')->placeholder('-'),
                        TextEntry::make('sigt_gl')->label('SIGT GL')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHsnMasters::route('/'),
            'create' => CreateHsnMaster::route('/create'),
            'view'   => ViewHsnMaster::route('/{record}'),
            'edit'   => EditHsnMaster::route('/{record}/edit'),
        ];
    }
}
