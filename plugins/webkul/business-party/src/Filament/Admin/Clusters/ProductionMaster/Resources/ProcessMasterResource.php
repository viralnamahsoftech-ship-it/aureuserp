<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources;

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
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource\Pages\CreateProcessMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource\Pages\EditProcessMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource\Pages\ListProcessMasters;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource\Pages\ViewProcessMaster;
use Webkul\BusinessParty\Models\ProcessMaster;

class ProcessMasterResource extends Resource
{
    protected static ?string $model = ProcessMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = ProductionMaster::class;

    protected static ?string $recordTitleAttribute = 'process_name';

    public static function getNavigationLabel(): string
    {
        return 'Process Master';
    }

    public static function getModelLabel(): string
    {
        return 'Process Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Process Master')
                    ->schema([
                        TextInput::make('pr_code')
                            ->label('Pr Code')
                            ->maxLength(4),
                        TextInput::make('process_name')
                            ->label('Process Name')
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
                TextColumn::make('pr_code')->label('Pr Code')->searchable()->sortable(),
                TextColumn::make('process_name')->label('Process Name')->searchable()->sortable(),
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
                Section::make('Process Master')
                    ->schema([
                        TextEntry::make('pr_code')->label('Pr Code')->placeholder('-'),
                        TextEntry::make('process_name')->label('Process Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProcessMasters::route('/'),
            'create' => CreateProcessMaster::route('/create'),
            'view'   => ViewProcessMaster::route('/{record}'),
            'edit'   => EditProcessMaster::route('/{record}/edit'),
        ];
    }
}
