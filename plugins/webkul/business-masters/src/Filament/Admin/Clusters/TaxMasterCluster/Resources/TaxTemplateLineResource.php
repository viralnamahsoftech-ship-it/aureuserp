<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources;

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
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource\Pages\CreateTaxTemplateLine;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource\Pages\EditTaxTemplateLine;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource\Pages\ListTaxTemplateLines;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource\Pages\ViewTaxTemplateLine;
use Webkul\BusinessMasters\Models\TaxTemplateLine;

class TaxTemplateLineResource extends Resource
{
    protected static ?string $model = TaxTemplateLine::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = TaxMasterCluster::class;

    protected static ?string $recordTitleAttribute = 'gl_code';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Tax Template Line';
    }

    public static function getModelLabel(): string
    {
        return 'Tax Template Line';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tax Template Line')
                    ->schema([
                        Select::make('tax_template_id')
                            ->label('Template')
                            ->relationship('taxTemplate', 'template_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
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
                            ->suffix('%'),
                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('gl_code')
                            ->label('GL Code')
                            ->maxLength(50),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('percentage')->label('Percentage')->searchable()->sortable(),
                TextColumn::make('amount')->label('Amount')->searchable()->sortable(),
                TextColumn::make('gl_code')->label('GL Code')->searchable()->sortable(),
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
                Section::make('Tax Template Line')
                    ->schema([
                        TextEntry::make('tax_template_id')->label('Template')->placeholder('-'),
                        TextEntry::make('tax_id')->label('Tax')->placeholder('-'),
                        TextEntry::make('percentage')->label('Percentage')->placeholder('-'),
                        TextEntry::make('amount')->label('Amount')->placeholder('-'),
                        TextEntry::make('gl_code')->label('GL Code')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTaxTemplateLines::route('/'),
            'create' => CreateTaxTemplateLine::route('/create'),
            'view'   => ViewTaxTemplateLine::route('/{record}'),
            'edit'   => EditTaxTemplateLine::route('/{record}/edit'),
        ];
    }
}
