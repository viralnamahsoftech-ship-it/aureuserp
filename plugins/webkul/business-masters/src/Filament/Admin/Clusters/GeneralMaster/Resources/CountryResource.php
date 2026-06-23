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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CountryResource\Pages\CreateCountry;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CountryResource\Pages\EditCountry;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CountryResource\Pages\ListCountries;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CountryResource\Pages\ViewCountry;
use Webkul\BusinessMasters\Models\Country;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'country_name';

    public static function getNavigationLabel(): string
    {
        return 'Country Master';
    }

    public static function getModelLabel(): string
    {
        return 'Country Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Country Master')
                    ->schema([
                        TextInput::make('country_code')
                            ->label('Country Code')
                            ->maxLength(5)
                            ->required(),
                        TextInput::make('country_name')
                            ->label('Country Name')
                            ->maxLength(100)
                            ->required(),
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
                TextColumn::make('country_code')->label('Country Code')->searchable()->sortable(),
                TextColumn::make('country_name')->label('Country Name')->searchable()->sortable(),
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
                Section::make('Country Master')
                    ->schema([
                        TextEntry::make('country_code')->label('Country Code')->placeholder('-'),
                        TextEntry::make('country_name')->label('Country Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'view'   => ViewCountry::route('/{record}'),
            'edit'   => EditCountry::route('/{record}/edit'),
        ];
    }
}
