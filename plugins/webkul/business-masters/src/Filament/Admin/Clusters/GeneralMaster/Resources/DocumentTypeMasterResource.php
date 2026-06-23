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
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentTypeMasterResource\Pages\CreateDocumentTypeMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentTypeMasterResource\Pages\EditDocumentTypeMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentTypeMasterResource\Pages\ListDocumentTypeMasters;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentTypeMasterResource\Pages\ViewDocumentTypeMaster;
use Webkul\BusinessMasters\Models\DocumentTypeMaster;

class DocumentTypeMasterResource extends Resource
{
    protected static ?string $model = DocumentTypeMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 9;

    protected static ?string $cluster = GeneralMaster::class;

    protected static ?string $recordTitleAttribute = 'document_type';

    public static function getNavigationLabel(): string
    {
        return 'Document Type Master';
    }

    public static function getModelLabel(): string
    {
        return 'Document Type Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document Type Master')
                    ->schema([
                        Select::make('document_type')
                            ->label('Document Type')
                            ->options([
                                'Vendor Quotation'   => 'Vendor Quotation',
                                'Cust PO'            => 'Cust PO',
                                'Cust Drawing'       => 'Cust Drawing',
                                'Cust Technical Doc' => 'Cust Technical Doc',
                                'Party Document'     => 'Party Document',
                                'Our Drawing Doc'    => 'Our Drawing Doc',
                                'Our Technical Doc'  => 'Our Technical Doc',
                                'Vendor Other Doc'   => 'Vendor Other Doc',
                                'Customer Other Doc' => 'Customer Other Doc',
                            ])
                            ->native(false)
                            ->required(),
                        TextInput::make('sub_doc_type')
                            ->label('Sub Doc Type')
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
                TextColumn::make('document_type')->label('Document Type')->searchable()->sortable(),
                TextColumn::make('sub_doc_type')->label('Sub Doc Type')->searchable()->sortable(),
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
                Section::make('Document Type Master')
                    ->schema([
                        TextEntry::make('document_type')->label('Document Type')->placeholder('-'),
                        TextEntry::make('sub_doc_type')->label('Sub Doc Type')->placeholder('-'),
                        IconEntry::make('is_active')->label('Active')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDocumentTypeMasters::route('/'),
            'create' => CreateDocumentTypeMaster::route('/create'),
            'view'   => ViewDocumentTypeMaster::route('/{record}'),
            'edit'   => EditDocumentTypeMaster::route('/{record}/edit'),
        ];
    }
}
