<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources;

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
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource\Pages\CreateIndustryType;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource\Pages\EditIndustryType;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource\Pages\ListIndustryTypes;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource\Pages\ViewIndustryType;
use Webkul\BusinessParty\Models\IndustryType;

class IndustryTypeResource extends Resource
{
    protected static ?string $model = IndustryType::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'industry_name';

    public static function getNavigationLabel(): string
    {
        return 'Inducstry Type';
    }

    public static function getModelLabel(): string
    {
        return 'Inducstry Type';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inducstry Type')
                    ->schema([
                        TextInput::make('industry_name')
                            ->label('Industry Type')
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
                TextColumn::make('industry_name')->label('Industry Type')->searchable()->sortable(),
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
                Section::make('Inducstry Type')
                    ->schema([
                        TextEntry::make('industry_name')->label('Industry Type')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListIndustryTypes::route('/'),
            'create' => CreateIndustryType::route('/create'),
            'view'   => ViewIndustryType::route('/{record}'),
            'edit'   => EditIndustryType::route('/{record}/edit'),
        ];
    }
}
