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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DepartmentResource\Pages\CreateDepartment;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DepartmentResource\Pages\EditDepartment;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DepartmentResource\Pages\ListDepartments;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DepartmentResource\Pages\ViewDepartment;
use Webkul\BusinessMasters\Models\Department;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'dept_name';

    public static function getNavigationLabel(): string
    {
        return 'Department';
    }

    public static function getModelLabel(): string
    {
        return 'Department';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Department')
                    ->schema([
                        TextInput::make('dept_code')
                            ->label('Department Code')
                            ->maxLength(20),
                        TextInput::make('dept_name')
                            ->label('Department Name')
                            ->maxLength(100)
                            ->required(),
                        Select::make('parent_dept_id')
                            ->label('Parent Department')
                            ->relationship('parentDept', 'dept_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
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
                TextColumn::make('dept_code')->label('Department Code')->searchable()->sortable(),
                TextColumn::make('dept_name')->label('Department Name')->searchable()->sortable(),
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
                Section::make('Department')
                    ->schema([
                        TextEntry::make('dept_code')->label('Department Code')->placeholder('-'),
                        TextEntry::make('dept_name')->label('Department Name')->placeholder('-'),
                        TextEntry::make('parent_dept_id')->label('Parent Department')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'view'   => ViewDepartment::route('/{record}'),
            'edit'   => EditDepartment::route('/{record}/edit'),
        ];
    }
}
