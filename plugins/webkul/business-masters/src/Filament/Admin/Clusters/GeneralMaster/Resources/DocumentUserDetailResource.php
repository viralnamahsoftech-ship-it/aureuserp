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
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource\Pages\CreateDocumentUserDetail;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource\Pages\EditDocumentUserDetail;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource\Pages\ListDocumentUserDetails;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource\Pages\ViewDocumentUserDetail;
use Webkul\BusinessMasters\Models\DocumentUserDetail;

class DocumentUserDetailResource extends Resource
{
    protected static ?string $model = DocumentUserDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 10;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'sub_doc_type';

    public static function getNavigationLabel(): string
    {
        return 'Document User Details';
    }

    public static function getModelLabel(): string
    {
        return 'Document User Details';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document User Details')
                    ->schema([
                        Select::make('document_type_id')
                            ->label('Document Type')
                            ->relationship('documentType', 'document_type')
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
                        TextInput::make('sub_doc_type')
                            ->label('Sub Doc Type')
                            ->maxLength(100),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sub_doc_type')->label('Sub Doc Type')->searchable()->sortable(),
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
                Section::make('Document User Details')
                    ->schema([
                        TextEntry::make('document_type_id')->label('Document Type')->placeholder('-'),
                        TextEntry::make('user_id')->label('User')->placeholder('-'),
                        TextEntry::make('sub_doc_type')->label('Sub Doc Type')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDocumentUserDetails::route('/'),
            'create' => CreateDocumentUserDetail::route('/create'),
            'view'   => ViewDocumentUserDetail::route('/{record}'),
            'edit'   => EditDocumentUserDetail::route('/{record}/edit'),
        ];
    }
}
