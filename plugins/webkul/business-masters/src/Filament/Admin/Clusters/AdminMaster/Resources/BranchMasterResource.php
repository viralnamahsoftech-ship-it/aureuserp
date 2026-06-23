<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource\Pages\CreateBranchMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource\Pages\EditBranchMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource\Pages\ListBranchMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource\Pages\ViewBranchMaster;
use Webkul\BusinessMasters\Models\BranchMaster;

class BranchMasterResource extends Resource
{
    protected static ?string $model = BranchMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'branch_name';

    public static function getNavigationLabel(): string
    {
        return 'Branch Master';
    }

    public static function getModelLabel(): string
    {
        return 'Branch Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branch Master')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('branch_code')
                            ->label('Branch Code')
                            ->maxLength(20)
                            ->required(),
                        TextInput::make('branch_name')
                            ->label('Branch Name')
                            ->maxLength(255)
                            ->required(),
                        Textarea::make('address')
                            ->label('Address'),
                        TextInput::make('city')
                            ->label('City')
                            ->maxLength(100),
                        TextInput::make('state')
                            ->label('State')
                            ->maxLength(100),
                        TextInput::make('country')
                            ->label('Country')
                            ->maxLength(100),
                        TextInput::make('pincode')
                            ->label('Pincode')
                            ->maxLength(20)
                            ->rules(['nullable', 'digits_between:6,10']),
                        FileUpload::make('header_file')
                            ->label('Header File')
                            ->image()
                            ->disk('public')
                            ->directory('business/header-file')
                            ->visibility('public'),
                        FileUpload::make('footer_file')
                            ->label('Footer File')
                            ->image()
                            ->disk('public')
                            ->directory('business/footer-file')
                            ->visibility('public'),
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
                TextColumn::make('branch_code')->label('Branch Code')->searchable()->sortable(),
                TextColumn::make('branch_name')->label('Branch Name')->searchable()->sortable(),
                TextColumn::make('city')->label('City')->searchable()->sortable(),
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
                Section::make('Branch Master')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_code')->label('Branch Code')->placeholder('-'),
                        TextEntry::make('branch_name')->label('Branch Name')->placeholder('-'),
                        TextEntry::make('address')->label('Address')->placeholder('-'),
                        TextEntry::make('city')->label('City')->placeholder('-'),
                        TextEntry::make('state')->label('State')->placeholder('-'),
                        TextEntry::make('country')->label('Country')->placeholder('-'),
                        TextEntry::make('pincode')->label('Pincode')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBranchMasters::route('/'),
            'create' => CreateBranchMaster::route('/create'),
            'view'   => ViewBranchMaster::route('/{record}'),
            'edit'   => EditBranchMaster::route('/{record}/edit'),
        ];
    }
}
