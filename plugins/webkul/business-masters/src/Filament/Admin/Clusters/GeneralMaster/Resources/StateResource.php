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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StateResource\Pages\CreateState;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StateResource\Pages\EditState;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StateResource\Pages\ListStates;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StateResource\Pages\ViewState;
use Webkul\BusinessMasters\Models\State;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'state_name';

    public static function getNavigationLabel(): string
    {
        return 'State Master';
    }

    public static function getModelLabel(): string
    {
        return 'State Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('State Master')
                    ->schema([
                        Select::make('country_id')
                            ->label('Country')
                            ->relationship('country', 'country_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('state_code')
                            ->label('State Code')
                            ->maxLength(10)
                            ->required(),
                        TextInput::make('state_name')
                            ->label('State Name')
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
                TextColumn::make('state_code')->label('State Code')->searchable()->sortable(),
                TextColumn::make('state_name')->label('State Name')->searchable()->sortable(),
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
                Section::make('State Master')
                    ->schema([
                        TextEntry::make('country_id')->label('Country')->placeholder('-'),
                        TextEntry::make('state_code')->label('State Code')->placeholder('-'),
                        TextEntry::make('state_name')->label('State Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListStates::route('/'),
            'create' => CreateState::route('/create'),
            'view'   => ViewState::route('/{record}'),
            'edit'   => EditState::route('/{record}/edit'),
        ];
    }
}
