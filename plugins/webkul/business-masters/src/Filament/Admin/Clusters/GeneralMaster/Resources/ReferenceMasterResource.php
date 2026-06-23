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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\ReferenceMasterResource\Pages\CreateReferenceMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\ReferenceMasterResource\Pages\EditReferenceMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\ReferenceMasterResource\Pages\ListReferenceMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\ReferenceMasterResource\Pages\ViewReferenceMaster;
use Webkul\BusinessMasters\Models\ReferenceMaster;

class ReferenceMasterResource extends Resource
{
    protected static ?string $model = ReferenceMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'ref_name';

    public static function getNavigationLabel(): string
    {
        return 'Referance Master';
    }

    public static function getModelLabel(): string
    {
        return 'Referance Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Referance Master')
                    ->schema([
                        TextInput::make('ref_name')
                            ->label('Reference Name')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('ref_type')
                            ->label('Reference Type')
                            ->maxLength(100),
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
                TextColumn::make('ref_name')->label('Reference Name')->searchable()->sortable(),
                TextColumn::make('ref_type')->label('Reference Type')->searchable()->sortable(),
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
                Section::make('Referance Master')
                    ->schema([
                        TextEntry::make('ref_name')->label('Reference Name')->placeholder('-'),
                        TextEntry::make('ref_type')->label('Reference Type')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListReferenceMasters::route('/'),
            'create' => CreateReferenceMaster::route('/create'),
            'view'   => ViewReferenceMaster::route('/{record}'),
            'edit'   => EditReferenceMaster::route('/{record}/edit'),
        ];
    }
}
