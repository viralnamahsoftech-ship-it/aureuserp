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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\CompanyMasterResource\Pages\CreateCompanyMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\CompanyMasterResource\Pages\EditCompanyMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\CompanyMasterResource\Pages\ListCompanyMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\CompanyMasterResource\Pages\ViewCompanyMaster;
use Webkul\BusinessMasters\Models\CompanyMaster;

class CompanyMasterResource extends Resource
{
    protected static ?string $model = CompanyMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function getNavigationLabel(): string
    {
        return 'Company Master';
    }

    public static function getModelLabel(): string
    {
        return 'Company Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Master')
                    ->schema([
                        TextInput::make('company_code')
                            ->label('Company Code')
                            ->maxLength(20)
                            ->required(),
                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('gstin')
                            ->label('GSTIN')
                            ->maxLength(30),
                        TextInput::make('pan_no')
                            ->label('PAN No')
                            ->maxLength(20),
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
                        TextInput::make('phone')
                            ->label('Phone')
                            ->maxLength(30),
                        TextInput::make('mobile')
                            ->label('Mobile')
                            ->maxLength(30),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('business/logo-path')
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
                TextColumn::make('company_code')->label('Company Code')->searchable()->sortable(),
                TextColumn::make('company_name')->label('Company Name')->searchable()->sortable(),
                TextColumn::make('gstin')->label('GSTIN')->searchable()->sortable(),
                TextColumn::make('pan_no')->label('PAN No')->searchable()->sortable(),
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
                Section::make('Company Master')
                    ->schema([
                        TextEntry::make('company_code')->label('Company Code')->placeholder('-'),
                        TextEntry::make('company_name')->label('Company Name')->placeholder('-'),
                        TextEntry::make('gstin')->label('GSTIN')->placeholder('-'),
                        TextEntry::make('pan_no')->label('PAN No')->placeholder('-'),
                        TextEntry::make('address')->label('Address')->placeholder('-'),
                        TextEntry::make('city')->label('City')->placeholder('-'),
                        TextEntry::make('state')->label('State')->placeholder('-'),
                        TextEntry::make('country')->label('Country')->placeholder('-'),
                        TextEntry::make('pincode')->label('Pincode')->placeholder('-'),
                        TextEntry::make('phone')->label('Phone')->placeholder('-'),
                        TextEntry::make('mobile')->label('Mobile')->placeholder('-'),
                        TextEntry::make('email')->label('Email')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCompanyMasters::route('/'),
            'create' => CreateCompanyMaster::route('/create'),
            'view'   => ViewCompanyMaster::route('/{record}'),
            'edit'   => EditCompanyMaster::route('/{record}/edit'),
        ];
    }
}
