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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource\Pages\CreatePartyBankDetail;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource\Pages\EditPartyBankDetail;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource\Pages\ListPartyBankDetails;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource\Pages\ViewPartyBankDetail;
use Webkul\BusinessParty\Models\PartyBankDetail;

class PartyBankDetailResource extends Resource
{
    protected static ?string $model = PartyBankDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'bank_name';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Party Bank Details';
    }

    public static function getModelLabel(): string
    {
        return 'Party Bank Details';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Bank Details')
                    ->schema([
                        Select::make('party_id')
                            ->label('Party')
                            ->relationship('party', 'party_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                        TextInput::make('bank_name')
                            ->label('Bank Name')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('account_name')
                            ->label('Account Name')
                            ->maxLength(255),
                        TextInput::make('account_no')
                            ->label('Account No')
                            ->maxLength(50),
                        TextInput::make('account_type')
                            ->label('Account Type')
                            ->maxLength(50),
                        TextInput::make('ifsc_code')
                            ->label('ISFC Code')
                            ->maxLength(20),
                        TextInput::make('ocr_no')
                            ->label('OCR No')
                            ->maxLength(50),
                        TextInput::make('icri_number')
                            ->label('ICRI Number')
                            ->maxLength(50),
                        TextInput::make('branch_name')
                            ->label('Branch Name')
                            ->maxLength(255),
                        Textarea::make('branch_address')
                            ->label('Branch Address'),
                        TextInput::make('branch_code')
                            ->label('Branch Code')
                            ->maxLength(20),
                        Toggle::make('is_whatsapp')
                            ->label('IS What app Numer')
                            ->default(false),
                        Toggle::make('auto_mail')
                            ->label('Auto mail')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_name')->label('Bank Name')->searchable()->sortable(),
                TextColumn::make('account_name')->label('Account Name')->searchable()->sortable(),
                TextColumn::make('account_no')->label('Account No')->searchable()->sortable(),
                TextColumn::make('account_type')->label('Account Type')->searchable()->sortable(),
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
                Section::make('Party Bank Details')
                    ->schema([
                        TextEntry::make('party_id')->label('Party')->placeholder('-'),
                        TextEntry::make('bank_name')->label('Bank Name')->placeholder('-'),
                        TextEntry::make('account_name')->label('Account Name')->placeholder('-'),
                        TextEntry::make('account_no')->label('Account No')->placeholder('-'),
                        TextEntry::make('account_type')->label('Account Type')->placeholder('-'),
                        TextEntry::make('ifsc_code')->label('ISFC Code')->placeholder('-'),
                        TextEntry::make('ocr_no')->label('OCR No')->placeholder('-'),
                        TextEntry::make('icri_number')->label('ICRI Number')->placeholder('-'),
                        TextEntry::make('branch_name')->label('Branch Name')->placeholder('-'),
                        TextEntry::make('branch_address')->label('Branch Address')->placeholder('-'),
                        TextEntry::make('branch_code')->label('Branch Code')->placeholder('-'),
                        IconEntry::make('is_whatsapp')->label('IS What app Numer')->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPartyBankDetails::route('/'),
            'create' => CreatePartyBankDetail::route('/create'),
            'view'   => ViewPartyBankDetail::route('/{record}'),
            'edit'   => EditPartyBankDetail::route('/{record}/edit'),
        ];
    }
}
