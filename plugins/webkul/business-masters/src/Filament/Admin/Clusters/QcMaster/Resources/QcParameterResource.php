<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources;

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
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource\Pages\CreateQcParameter;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource\Pages\EditQcParameter;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource\Pages\ListQcParameters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource\Pages\ViewQcParameter;
use Webkul\BusinessMasters\Models\QcParameter;

class QcParameterResource extends Resource
{
    protected static ?string $model = QcParameter::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = QcMaster::class;

    protected static ?string $recordTitleAttribute = 'parameter_name';

    public static function getNavigationLabel(): string
    {
        return 'QC Parameter Master';
    }

    public static function getModelLabel(): string
    {
        return 'QC Parameter Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('QC Parameter Master')
                    ->schema([
                        TextInput::make('parameter_name')
                            ->label('Parameter Name')
                            ->maxLength(255)
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
                TextColumn::make('parameter_name')->label('Parameter Name')->searchable()->sortable(),
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
                Section::make('QC Parameter Master')
                    ->schema([
                        TextEntry::make('parameter_name')->label('Parameter Name')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListQcParameters::route('/'),
            'create' => CreateQcParameter::route('/create'),
            'view'   => ViewQcParameter::route('/{record}'),
            'edit'   => EditQcParameter::route('/{record}/edit'),
        ];
    }
}
