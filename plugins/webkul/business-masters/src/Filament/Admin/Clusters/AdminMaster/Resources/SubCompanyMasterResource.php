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
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SubCompanyMasterResource\Pages\CreateSubCompanyMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SubCompanyMasterResource\Pages\EditSubCompanyMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SubCompanyMasterResource\Pages\ListSubCompanyMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SubCompanyMasterResource\Pages\ViewSubCompanyMaster;
use Webkul\BusinessMasters\Models\SubCompanyMaster;

class SubCompanyMasterResource extends Resource
{
    protected static ?string $model = SubCompanyMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'sub_company_name';

    public static function getNavigationLabel(): string
    {
        return 'Sub Company Master';
    }

    public static function getModelLabel(): string
    {
        return 'Sub Company Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sub Company Master')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('sub_company_code')
                            ->label('Sub Company Code')
                            ->maxLength(20)
                            ->required(),
                        TextInput::make('sub_company_name')
                            ->label('Sub Company Name')
                            ->maxLength(255)
                            ->required(),
                        Textarea::make('address')
                            ->label('Address'),
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
                TextColumn::make('sub_company_code')->label('Sub Company Code')->searchable()->sortable(),
                TextColumn::make('sub_company_name')->label('Sub Company Name')->searchable()->sortable(),
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
                Section::make('Sub Company Master')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('sub_company_code')->label('Sub Company Code')->placeholder('-'),
                        TextEntry::make('sub_company_name')->label('Sub Company Name')->placeholder('-'),
                        TextEntry::make('address')->label('Address')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSubCompanyMasters::route('/'),
            'create' => CreateSubCompanyMaster::route('/create'),
            'view'   => ViewSubCompanyMaster::route('/{record}'),
            'edit'   => EditSubCompanyMaster::route('/{record}/edit'),
        ];
    }
}
