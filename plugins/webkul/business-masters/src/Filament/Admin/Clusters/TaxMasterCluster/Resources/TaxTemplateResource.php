<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource\Pages\CreateTaxTemplate;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource\Pages\EditTaxTemplate;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource\Pages\ListTaxTemplates;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource\Pages\ViewTaxTemplate;
use Webkul\BusinessMasters\Models\TaxTemplate;
use Webkul\Support\Filament\Forms\Components\Repeater;
use Webkul\Support\Filament\Forms\Components\Repeater\TableColumn as RepeaterTableColumn;

class TaxTemplateResource extends Resource
{
    protected static ?string $model = TaxTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = TaxMasterCluster::class;

    protected static ?string $recordTitleAttribute = 'template_name';

    public static function getNavigationLabel(): string
    {
        return 'Tax Templete';
    }

    public static function getModelLabel(): string
    {
        return 'Tax Templete';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tax Templete')
                    ->schema([
                        TextInput::make('template_name')
                            ->label('Template Name')
                            ->maxLength(255)
                            ->required(),
                        Textarea::make('definition')
                            ->label('Definition'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
                Section::make('Tax Template Lines')
                    ->schema([
                        Repeater::make('lines')
                            ->hiddenLabel()
                            ->relationship('lines')
                            ->defaultItems(0)
                            ->compact()
                            ->addActionLabel('Add Tax Line')
                            ->table([
                                RepeaterTableColumn::make('tax_id')->label('Tax')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('percentage')->label('Percentage')->resizable(),
                                RepeaterTableColumn::make('amount')->label('Amount')->resizable(),
                                RepeaterTableColumn::make('gl_code')->label('GL Code')->resizable(),
                            ])
                            ->schema([
                                Select::make('tax_id')
                                    ->label('Tax')
                                    ->relationship('tax', 'tax_name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required(),
                                TextInput::make('percentage')
                                    ->label('Percentage')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->step(0.0001),
                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.0001),
                                TextInput::make('gl_code')
                                    ->label('GL Code')
                                    ->maxLength(50),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('template_name')->label('Template Name')->searchable()->sortable(),
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
                Section::make('Tax Templete')
                    ->schema([
                        TextEntry::make('template_name')->label('Template Name')->placeholder('-'),
                        TextEntry::make('definition')->label('Definition')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTaxTemplates::route('/'),
            'create' => CreateTaxTemplate::route('/create'),
            'view'   => ViewTaxTemplate::route('/{record}'),
            'edit'   => EditTaxTemplate::route('/{record}/edit'),
        ];
    }
}
