<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources;

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
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages\CreateOperatorMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages\EditOperatorMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages\ListOperatorMasters;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages\ViewOperatorMaster;
use Webkul\BusinessParty\Models\OperatorMaster;

class OperatorMasterResource extends Resource
{
    protected static ?string $model = OperatorMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = ProductionMaster::class;

    protected static ?string $recordTitleAttribute = 'operator_name';

    public static function getNavigationLabel(): string
    {
        return 'Operator Master';
    }

    public static function getModelLabel(): string
    {
        return 'Operator Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Operator Master')
                    ->schema([
                        Select::make('process_id')
                            ->label('Process Name')
                            ->relationship('process', 'process_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('user_id')
                            ->label('User Name')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('operator_name')
                            ->label('Operator Name')
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
                TextColumn::make('operator_name')->label('Operator Name')->searchable()->sortable(),
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
                Section::make('Operator Master')
                    ->schema([
                        TextEntry::make('process_id')->label('Process Name')->placeholder('-'),
                        TextEntry::make('user_id')->label('User Name')->placeholder('-'),
                        TextEntry::make('operator_name')->label('Operator Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListOperatorMasters::route('/'),
            'create' => CreateOperatorMaster::route('/create'),
            'view'   => ViewOperatorMaster::route('/{record}'),
            'edit'   => EditOperatorMaster::route('/{record}/edit'),
        ];
    }
}
