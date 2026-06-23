<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource\Pages\CreateBranchUserRight;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource\Pages\EditBranchUserRight;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource\Pages\ListBranchUserRights;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource\Pages\ViewBranchUserRight;
use Webkul\BusinessParty\Models\BranchUserRight;

class BranchUserRightResource extends Resource
{
    protected static ?string $model = BranchUserRight::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 8;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationLabel(): string
    {
        return 'Branch User Rights';
    }

    public static function getModelLabel(): string
    {
        return 'Branch User Rights';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branch User Rights')
                    ->schema([
                        Select::make('branch_id')
                            ->label('Branch')
                            ->relationship('branch', 'branch_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
                Section::make('Branch User Rights')
                    ->schema([
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('user_id')->label('User')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBranchUserRights::route('/'),
            'create' => CreateBranchUserRight::route('/create'),
            'view'   => ViewBranchUserRight::route('/{record}'),
            'edit'   => EditBranchUserRight::route('/{record}/edit'),
        ];
    }
}
