<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources;

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
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SerialNoMasterResource\Pages\CreateSerialNoMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SerialNoMasterResource\Pages\EditSerialNoMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SerialNoMasterResource\Pages\ListSerialNoMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SerialNoMasterResource\Pages\ViewSerialNoMaster;
use Webkul\BusinessMasters\Models\SerialNoMaster;

class SerialNoMasterResource extends Resource
{
    protected static ?string $model = SerialNoMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'doc_type';

    public static function getNavigationLabel(): string
    {
        return 'Serial No Master';
    }

    public static function getModelLabel(): string
    {
        return 'Serial No Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Serial No Master')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'branch_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('doc_type')
                            ->label('Document Type')
                            ->maxLength(100)
                            ->required(),
                        TextInput::make('prefix')
                            ->label('Prefix')
                            ->maxLength(20),
                        TextInput::make('suffix')
                            ->label('Suffix')
                            ->maxLength(20),
                        TextInput::make('separator')
                            ->label('Separator')
                            ->maxLength(5),
                        TextInput::make('current_no')
                            ->label('Current No')
                            ->integer()
                            ->minValue(0),
                        TextInput::make('pad_length')
                            ->label('Pad Length')
                            ->integer()
                            ->minValue(0),
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
                TextColumn::make('doc_type')->label('Document Type')->searchable()->sortable(),
                TextColumn::make('prefix')->label('Prefix')->searchable()->sortable(),
                TextColumn::make('suffix')->label('Suffix')->searchable()->sortable(),
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
                Section::make('Serial No Master')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('doc_type')->label('Document Type')->placeholder('-'),
                        TextEntry::make('prefix')->label('Prefix')->placeholder('-'),
                        TextEntry::make('suffix')->label('Suffix')->placeholder('-'),
                        TextEntry::make('separator')->label('Separator')->placeholder('-'),
                        TextEntry::make('current_no')->label('Current No')->placeholder('-'),
                        TextEntry::make('pad_length')->label('Pad Length')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSerialNoMasters::route('/'),
            'create' => CreateSerialNoMaster::route('/create'),
            'view'   => ViewSerialNoMaster::route('/{record}'),
            'edit'   => EditSerialNoMaster::route('/{record}/edit'),
        ];
    }
}
