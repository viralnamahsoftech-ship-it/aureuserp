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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DesignationResource\Pages\CreateDesignation;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DesignationResource\Pages\EditDesignation;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DesignationResource\Pages\ListDesignations;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DesignationResource\Pages\ViewDesignation;
use Webkul\BusinessMasters\Models\Designation;

class DesignationResource extends Resource
{
    protected static ?string $model = Designation::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'designation_name';

    public static function getNavigationLabel(): string
    {
        return 'Designation';
    }

    public static function getModelLabel(): string
    {
        return 'Designation';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Designation')
                    ->schema([
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'dept_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('designation_name')
                            ->label('Designation Name')
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
                TextColumn::make('designation_name')->label('Designation Name')->searchable()->sortable(),
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
                Section::make('Designation')
                    ->schema([
                        TextEntry::make('department_id')->label('Department')->placeholder('-'),
                        TextEntry::make('designation_name')->label('Designation Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDesignations::route('/'),
            'create' => CreateDesignation::route('/create'),
            'view'   => ViewDesignation::route('/{record}'),
            'edit'   => EditDesignation::route('/{record}/edit'),
        ];
    }
}
