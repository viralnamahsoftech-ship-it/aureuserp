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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CityResource\Pages\CreateCity;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CityResource\Pages\EditCity;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CityResource\Pages\ListCities;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CityResource\Pages\ViewCity;
use Webkul\BusinessMasters\Models\City;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'city_name';

    public static function getNavigationLabel(): string
    {
        return 'City Master';
    }

    public static function getModelLabel(): string
    {
        return 'City Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('City Master')
                    ->schema([
                        Select::make('state_id')
                            ->label('State')
                            ->relationship('state', 'state_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('city_name')
                            ->label('City Name')
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
                TextColumn::make('city_name')->label('City Name')->searchable()->sortable(),
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
                Section::make('City Master')
                    ->schema([
                        TextEntry::make('state_id')->label('State')->placeholder('-'),
                        TextEntry::make('city_name')->label('City Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCities::route('/'),
            'create' => CreateCity::route('/create'),
            'view'   => ViewCity::route('/{record}'),
            'edit'   => EditCity::route('/{record}/edit'),
        ];
    }
}
