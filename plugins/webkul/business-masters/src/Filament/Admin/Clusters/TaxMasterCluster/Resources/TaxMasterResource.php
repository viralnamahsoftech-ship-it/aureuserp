<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources;

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
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxMasterResource\Pages\CreateTaxMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxMasterResource\Pages\EditTaxMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxMasterResource\Pages\ListTaxMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxMasterResource\Pages\ViewTaxMaster;
use Webkul\BusinessMasters\Models\TaxMaster;

class TaxMasterResource extends Resource
{
    protected static ?string $model = TaxMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = TaxMasterCluster::class;

    protected static ?string $recordTitleAttribute = 'tax_name';

    public static function getNavigationLabel(): string
    {
        return 'Tax Master';
    }

    public static function getModelLabel(): string
    {
        return 'Tax Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tax Master')
                    ->schema([
                        TextInput::make('tax_code')
                            ->label('Tax Code')
                            ->maxLength(20)
                            ->required(),
                        TextInput::make('tax_name')
                            ->label('Tax Name')
                            ->maxLength(100)
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
                TextColumn::make('tax_code')->label('Tax Code')->searchable()->sortable(),
                TextColumn::make('tax_name')->label('Tax Name')->searchable()->sortable(),
                TextColumn::make('percentage')->label('Percentage')->searchable()->sortable(),
                TextColumn::make('amount')->label('Amount')->searchable()->sortable(),
                TextColumn::make('gl_code')->label('GL Code')->searchable()->sortable(),
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
                Section::make('Tax Master')
                    ->schema([
                        TextEntry::make('tax_code')->label('Tax Code')->placeholder('-'),
                        TextEntry::make('tax_name')->label('Tax Name')->placeholder('-'),
                        TextEntry::make('percentage')->label('Percentage')->placeholder('-'),
                        TextEntry::make('amount')->label('Amount')->placeholder('-'),
                        TextEntry::make('gl_code')->label('GL Code')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTaxMasters::route('/'),
            'create' => CreateTaxMaster::route('/create'),
            'view'   => ViewTaxMaster::route('/{record}'),
            'edit'   => EditTaxMaster::route('/{record}/edit'),
        ];
    }
}
