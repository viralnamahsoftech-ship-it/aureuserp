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
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSerialNoResource\Pages\CreateDocWiseSerialNo;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSerialNoResource\Pages\EditDocWiseSerialNo;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSerialNoResource\Pages\ListDocWiseSerialNos;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSerialNoResource\Pages\ViewDocWiseSerialNo;
use Webkul\BusinessMasters\Models\DocWiseSerialNo;

class DocWiseSerialNoResource extends Resource
{
    protected static ?string $model = DocWiseSerialNo::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'document_type';

    public static function getNavigationLabel(): string
    {
        return 'Doc Wise Serial No';
    }

    public static function getModelLabel(): string
    {
        return 'Doc Wise Serial No';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Doc Wise Serial No')
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
                        TextInput::make('document_type')
                            ->label('Document Type')
                            ->maxLength(100)
                            ->required(),
                        Select::make('serial_no_id')
                            ->label('Serial No')
                            ->relationship('serialNo', 'doc_type')
                            ->searchable()
                            ->preload()
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_type')->label('Document Type')->searchable()->sortable(),
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
                Section::make('Doc Wise Serial No')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('document_type')->label('Document Type')->placeholder('-'),
                        TextEntry::make('serial_no_id')->label('Serial No')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDocWiseSerialNos::route('/'),
            'create' => CreateDocWiseSerialNo::route('/create'),
            'view'   => ViewDocWiseSerialNo::route('/{record}'),
            'edit'   => EditDocWiseSerialNo::route('/{record}/edit'),
        ];
    }
}
