<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources;

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
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateResource\Pages\CreateQcTemplate;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateResource\Pages\EditQcTemplate;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateResource\Pages\ListQcTemplates;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateResource\Pages\ViewQcTemplate;
use Webkul\BusinessMasters\Models\QcTemplate;
use Webkul\Support\Filament\Forms\Components\Repeater;
use Webkul\Support\Filament\Forms\Components\Repeater\TableColumn as RepeaterTableColumn;

class QcTemplateResource extends Resource
{
    protected static ?string $model = QcTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = QcMaster::class;

    protected static ?string $recordTitleAttribute = 'qc_temp_name';

    public static function getNavigationLabel(): string
    {
        return 'QC Templete';
    }

    public static function getModelLabel(): string
    {
        return 'QC Templete';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('QC Templete')
                    ->schema([
                        TextInput::make('qc_temp_code')
                            ->label('QC Template Code')
                            ->maxLength(30)
                            ->required(),
                        TextInput::make('qc_temp_name')
                            ->label('QC Template Name')
                            ->maxLength(255)
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
                Section::make('QC Template Lines')
                    ->schema([
                        Repeater::make('lines')
                            ->hiddenLabel()
                            ->relationship('lines')
                            ->defaultItems(0)
                            ->compact()
                            ->addActionLabel('Add QC Line')
                            ->table([
                                RepeaterTableColumn::make('qc_parameter_id')->label('QC Parameter')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('min_value')->label('Min Value')->resizable(),
                                RepeaterTableColumn::make('max_value')->label('Max Value')->resizable(),
                                RepeaterTableColumn::make('result_type')->label('Result Type')->resizable(),
                                RepeaterTableColumn::make('sort_order')->label('Sort')->resizable(),
                            ])
                            ->schema([
                                Select::make('qc_parameter_id')
                                    ->label('QC Parameter')
                                    ->relationship('parameter', 'parameter_name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required(),
                                TextInput::make('min_value')
                                    ->label('Min Value')
                                    ->numeric()
                                    ->step(0.0001),
                                TextInput::make('max_value')
                                    ->label('Max Value')
                                    ->numeric()
                                    ->step(0.0001),
                                Select::make('result_type')
                                    ->label('Result Type')
                                    ->options([
                                        'Numeric'  => 'Numeric',
                                        'Text'     => 'Text',
                                        'PassFail' => 'Pass / Fail',
                                    ])
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
                TextColumn::make('qc_temp_code')->label('QC Template Code')->searchable()->sortable(),
                TextColumn::make('qc_temp_name')->label('QC Template Name')->searchable()->sortable(),
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
                Section::make('QC Templete')
                    ->schema([
                        TextEntry::make('qc_temp_code')->label('QC Template Code')->placeholder('-'),
                        TextEntry::make('qc_temp_name')->label('QC Template Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListQcTemplates::route('/'),
            'create' => CreateQcTemplate::route('/create'),
            'view'   => ViewQcTemplate::route('/{record}'),
            'edit'   => EditQcTemplate::route('/{record}/edit'),
        ];
    }
}
