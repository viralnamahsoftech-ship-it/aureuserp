<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources;

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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CurrencyResource\Pages\CreateCurrency;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CurrencyResource\Pages\EditCurrency;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CurrencyResource\Pages\ListCurrencies;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CurrencyResource\Pages\ViewCurrency;
use Webkul\BusinessMasters\Models\Currency;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'currency_name';

    public static function getNavigationLabel(): string
    {
        return 'Currency';
    }

    public static function getModelLabel(): string
    {
        return 'Currency';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Currency')
                    ->schema([
                        TextInput::make('currency_code')
                            ->label('Currency Code')
                            ->maxLength(10)
                            ->required(),
                        TextInput::make('currency_name')
                            ->label('Currency Name')
                            ->maxLength(100)
                            ->required(),
                        TextInput::make('conv_rate')
                            ->label('Conv Rate')
                            ->numeric()
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
                TextColumn::make('currency_code')->label('Currency Code')->searchable()->sortable(),
                TextColumn::make('currency_name')->label('Currency Name')->searchable()->sortable(),
                TextColumn::make('conv_rate')->label('Conv Rate')->searchable()->sortable(),
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
                Section::make('Currency')
                    ->schema([
                        TextEntry::make('currency_code')->label('Currency Code')->placeholder('-'),
                        TextEntry::make('currency_name')->label('Currency Name')->placeholder('-'),
                        TextEntry::make('conv_rate')->label('Conv Rate')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCurrencies::route('/'),
            'create' => CreateCurrency::route('/create'),
            'view'   => ViewCurrency::route('/{record}'),
            'edit'   => EditCurrency::route('/{record}/edit'),
        ];
    }
}
