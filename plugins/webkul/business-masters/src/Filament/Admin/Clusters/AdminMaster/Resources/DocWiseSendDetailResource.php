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
use Filament\Tables\Table;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource\Pages\CreateDocWiseSendDetail;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource\Pages\EditDocWiseSendDetail;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource\Pages\ListDocWiseSendDetails;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource\Pages\ViewDocWiseSendDetail;
use Webkul\BusinessMasters\Models\DocWiseSendDetail;

class DocWiseSendDetailResource extends Resource
{
    protected static ?string $model = DocWiseSendDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $cluster = AdminMaster::class;

    protected static ?string $recordTitleAttribute = 'document_type';

    public static function getNavigationLabel(): string
    {
        return 'Doc Wise send Details';
    }

    public static function getModelLabel(): string
    {
        return 'Doc Wise send Details';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Doc Wise send Details')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('document_type')
                            ->label('Document Type')
                            ->maxLength(100)
                            ->required(),
                        Toggle::make('send_via_email')
                            ->label('Send Via Email')
                            ->default(false),
                        Toggle::make('send_via_whatsapp')
                            ->label('Send Via WhatsApp')
                            ->default(false),
                        Textarea::make('email_template')
                            ->label('Email Template'),
                        Textarea::make('whatsapp_template')
                            ->label('WhatsApp Template'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_type')->label('Document Type')->searchable()->sortable(),
                IconColumn::make('send_via_email')->label('Send Via Email')->boolean()->sortable(),
                IconColumn::make('send_via_whatsapp')->label('Send Via WhatsApp')->boolean()->sortable(),
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
                Section::make('Doc Wise send Details')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('document_type')->label('Document Type')->placeholder('-'),
                        IconEntry::make('send_via_email')->label('Send Via Email')->boolean(),
                        IconEntry::make('send_via_whatsapp')->label('Send Via WhatsApp')->boolean(),
                        TextEntry::make('email_template')->label('Email Template')->placeholder('-'),
                        TextEntry::make('whatsapp_template')->label('WhatsApp Template')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListDocWiseSendDetails::route('/'),
            'create' => CreateDocWiseSendDetail::route('/create'),
            'view'   => ViewDocWiseSendDetail::route('/{record}'),
            'edit'   => EditDocWiseSendDetail::route('/{record}/edit'),
        ];
    }
}
