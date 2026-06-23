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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\TaskTypeResource\Pages\CreateTaskType;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\TaskTypeResource\Pages\EditTaskType;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\TaskTypeResource\Pages\ListTaskTypes;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\TaskTypeResource\Pages\ViewTaskType;
use Webkul\BusinessMasters\Models\TaskType;

class TaskTypeResource extends Resource
{
    protected static ?string $model = TaskType::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 11;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'task_name';

    public static function getNavigationLabel(): string
    {
        return 'Task Tyoe';
    }

    public static function getModelLabel(): string
    {
        return 'Task Tyoe';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task Tyoe')
                    ->schema([
                        TextInput::make('task_name')
                            ->label('Task Name')
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
                TextColumn::make('task_name')->label('Task Name')->searchable()->sortable(),
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
                Section::make('Task Tyoe')
                    ->schema([
                        TextEntry::make('task_name')->label('Task Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTaskTypes::route('/'),
            'create' => CreateTaskType::route('/create'),
            'view'   => ViewTaskType::route('/{record}'),
            'edit'   => EditTaskType::route('/{record}/edit'),
        ];
    }
}
