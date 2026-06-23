<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource\Pages\CreateStageMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource\Pages\EditStageMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource\Pages\ListStageMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource\Pages\ViewStageMaster;
use Webkul\BusinessMasters\Models\StageMaster;

class StageMasterResource extends Resource
{
    protected static ?string $model = StageMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 8;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'stage_name';

    public static function getNavigationLabel(): string
    {
        return 'Stage Master';
    }

    public static function getModelLabel(): string
    {
        return 'Stage Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Stage Master')
                    ->schema([
                        Select::make('form_name')
                            ->label('Form Name')
                            ->options([
                                'Lead'             => 'Lead',
                                'Quotation'        => 'Quotation',
                                'Sales Order'      => 'Sales Order',
                                'Proforma Invoice' => 'Proforma Invoice',
                                'Sales Invoice'    => 'Sales Invoice',
                                'Purchase Order'   => 'Purchase Order',
                                'Purchase Invoice' => 'Purchase Invoice',
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('stage_name')
                            ->label('Stage Name')
                            ->maxLength(100)
                            ->required(),
                        Textarea::make('details')
                            ->label('Details'),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->integer()
                            ->minValue(0),
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
                TextColumn::make('form_name')->label('Form Name')->searchable()->sortable(),
                TextColumn::make('stage_name')->label('Stage Name')->searchable()->sortable(),
                TextColumn::make('sort_order')->label('Sort Order')->searchable()->sortable(),
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
                Section::make('Stage Master')
                    ->schema([
                        TextEntry::make('form_name')->label('Form Name')->placeholder('-'),
                        TextEntry::make('stage_name')->label('Stage Name')->placeholder('-'),
                        TextEntry::make('details')->label('Details')->placeholder('-'),
                        TextEntry::make('sort_order')->label('Sort Order')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStageMasters::route('/'),
            'create' => CreateStageMaster::route('/create'),
            'view'   => ViewStageMaster::route('/{record}'),
            'edit'   => EditStageMaster::route('/{record}/edit'),
        ];
    }
}
