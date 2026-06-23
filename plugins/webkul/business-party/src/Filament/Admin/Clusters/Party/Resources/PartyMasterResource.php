<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources;

use BackedEnum;
use Filament\Actions\Action;
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
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource\Pages\CreatePartyMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource\Pages\EditPartyMaster;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource\Pages\ListPartyMasters;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource\Pages\ViewPartyMaster;
use Webkul\BusinessParty\Models\PartyMaster;
use Webkul\Support\Filament\Forms\Components\Repeater;
use Webkul\Support\Filament\Forms\Components\Repeater\TableColumn as RepeaterTableColumn;

class PartyMasterResource extends Resource
{
    protected static ?string $model = PartyMaster::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $cluster = Party::class;

    protected static ?string $recordTitleAttribute = 'party_name';

    public static function getNavigationLabel(): string
    {
        return 'Party Master';
    }

    public static function getModelLabel(): string
    {
        return 'Party Master';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Party Master')
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
                        TextInput::make('party_code')
                            ->label('Party Code')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('Auto Generated')
                            ->maxLength(30),
                        TextInput::make('party_name')
                            ->label('Party Name')
                            ->maxLength(255)
                            ->required(),
                        Select::make('party_type_id')
                            ->label('Party Type')
                            ->relationship('partyType', 'ptype')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('party_group_id')
                            ->label('Party Group')
                            ->relationship('partyGroup', 'group_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('industry_type_id')
                            ->label('Industry Type')
                            ->relationship('industryType', 'industry_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('currency_id')
                            ->label('Currency')
                            ->relationship('currency', 'currency_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Textarea::make('ho_address')
                            ->label('HO Address'),
                        Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'city_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('state_id')
                            ->label('State')
                            ->relationship('state', 'state_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('country_id')
                            ->label('Country')
                            ->relationship('country', 'country_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('pincode')
                            ->label('Pincode')
                            ->maxLength(20)
                            ->rules(['nullable', 'digits_between:6,10']),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->maxLength(30),
                        TextInput::make('mobile')
                            ->label('Mobile')
                            ->tel()
                            ->rules(['nullable', 'digits:10'])
                            ->maxLength(30),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Select::make('gst_supply_type')
                            ->label('GST TAX SUP TYPE')
                            ->options([
                                'InterState' => 'InterState',
                                'IntraState' => 'IntraState',
                                'Export'     => 'Export',
                                'Import'     => 'Import',
                            ])
                            ->native(false),
                        Select::make('tax_on')
                            ->label('Tax On')
                            ->options([
                                'ItemWise'     => 'Item Wise',
                                'InvoiceBased' => 'Invoice Base',
                            ])
                            ->native(false),
                        TextInput::make('gstin')
                            ->label('GSTIN Number')
                            ->maxLength(30)
                            ->rules(['nullable', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'])
                            ->validationMessages(['regex' => 'Invalid GSTIN format. Expected: 22AAAAA0000A1Z5']),
                        TextInput::make('pan_no')
                            ->label('PAN No')
                            ->maxLength(20),
                        TextInput::make('ecc_no')
                            ->label('ECC')
                            ->maxLength(30),
                        TextInput::make('uan_no')
                            ->label('UAN')
                            ->maxLength(30),
                        TextInput::make('tin_no')
                            ->label('TIN No')
                            ->maxLength(30),
                        TextInput::make('msme_no')
                            ->label('MSME No')
                            ->maxLength(30),
                        Select::make('msme_type')
                            ->label('MSME Type')
                            ->options([
                                'High'   => 'High',
                                'Middle' => 'Middle',
                                'Small'  => 'Small',
                            ])
                            ->native(false),
                        TextInput::make('udaid_no')
                            ->label('UDAID No')
                            ->maxLength(30),
                        TextInput::make('other_ref_no')
                            ->label('Other Ref No')
                            ->maxLength(100),
                        TextInput::make('op_bal')
                            ->label('OP Bal')
                            ->numeric()
                            ->minValue(0),
                        Select::make('op_bal_type')
                            ->label('OPBal Type')
                            ->options([
                                'Dr' => 'Dr',
                                'Cr' => 'Cr',
                            ])
                            ->native(false),
                        TextInput::make('account_group_id')
                            ->label('Account Group Name')
                            ->integer()
                            ->minValue(0),
                        Toggle::make('is_tds_applicable')
                            ->label('IS TDS Applicable')
                            ->default(false),
                        TextInput::make('tds_payment_id')
                            ->label('TDS Payment')
                            ->integer()
                            ->minValue(0),
                        TextInput::make('gl_tds_code')
                            ->label('GL TDS Code')
                            ->maxLength(50),
                        TextInput::make('credit_limit')
                            ->label('Credit Limit')
                            ->numeric()
                            ->minValue(0),
                        Toggle::make('allow_multiple_invoice')
                            ->label('Allow Multiple Invoice')
                            ->default(false),
                        Toggle::make('is_parent_party')
                            ->label('Is Parent Party')
                            ->default(false),
                        Select::make('parent_party_id')
                            ->label('Parent Party Name')
                            ->relationship('parentParty', 'party_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(false),
                    ])
                    ->columns(2),
                Section::make('Party Addresses')
                    ->schema([
                        Repeater::make('addresses')
                            ->hiddenLabel()
                            ->relationship('addresses')
                            ->defaultItems(0)
                            ->compact()
                            ->addActionLabel('Add Address')
                            ->table([
                                RepeaterTableColumn::make('site_name')->label('Site Name')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('address_type')->label('Address Type')->resizable(),
                                RepeaterTableColumn::make('mobile')->label('Mobile')->resizable(),
                                RepeaterTableColumn::make('email')->label('Email')->resizable(),
                                RepeaterTableColumn::make('gstin')->label('GSTIN')->resizable(),
                            ])
                            ->schema([
                                TextInput::make('site_name')->label('Site Name')->required()->maxLength(255),
                                Select::make('address_type')
                                    ->label('Address Type')
                                    ->options([
                                        'Billing'  => 'Billing',
                                        'Shipping' => 'Shipping',
                                        'Factory'  => 'Factory',
                                        'Office'   => 'Office',
                                    ])
                                    ->native(false),
                                Textarea::make('address')->label('Address')->columnSpanFull(),
                                Select::make('city_id')->label('City')->relationship('city', 'city_name')->searchable()->preload()->native(false),
                                Select::make('state_id')->label('State')->relationship('state', 'state_name')->searchable()->preload()->native(false),
                                TextInput::make('state_code')->label('State Code')->maxLength(20),
                                Select::make('country_id')->label('Country')->relationship('country', 'country_name')->searchable()->preload()->native(false),
                                TextInput::make('pincode')->label('Pincode')->maxLength(20)->rules(['nullable', 'digits_between:6,10']),
                                TextInput::make('phone')->label('Phone')->maxLength(30),
                                TextInput::make('mobile')->label('Mobile')->tel()->rules(['nullable', 'digits:10'])->maxLength(30),
                                TextInput::make('email')->label('Email')->email()->maxLength(255),
                                TextInput::make('gstin')->label('GSTIN')->maxLength(30)->rules(['nullable', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/']),
                                Toggle::make('is_whatsapp')->label('WhatsApp')->default(false),
                                Toggle::make('auto_mail')->label('Auto Mail')->default(false),
                            ])
                            ->columns(2),
                    ]),
                Section::make('Contact Persons')
                    ->schema([
                        Repeater::make('contactPersons')
                            ->hiddenLabel()
                            ->relationship('contactPersons')
                            ->defaultItems(0)
                            ->compact()
                            ->addActionLabel('Add Contact')
                            ->table([
                                RepeaterTableColumn::make('contact_name')->label('Contact Name')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('site_name')->label('Site Name')->resizable(),
                                RepeaterTableColumn::make('mobile')->label('Mobile')->resizable(),
                                RepeaterTableColumn::make('email')->label('Email')->resizable(),
                            ])
                            ->schema([
                                TextInput::make('site_name')->label('Site Name')->maxLength(255),
                                TextInput::make('contact_name')->label('Contact Name')->required()->maxLength(255),
                                TextInput::make('department_id')->label('Department')->integer()->minValue(0),
                                TextInput::make('designation_id')->label('Designation')->integer()->minValue(0),
                                TextInput::make('mobile')->label('Mobile')->tel()->rules(['nullable', 'digits:10'])->maxLength(30),
                                TextInput::make('phone')->label('Phone')->maxLength(30),
                                TextInput::make('ext_no')->label('Ext No')->maxLength(20),
                                TextInput::make('email')->label('Email')->email()->maxLength(255),
                                Toggle::make('is_whatsapp')->label('WhatsApp')->default(false),
                                Toggle::make('auto_mail')->label('Auto Mail')->default(false),
                            ])
                            ->columns(2),
                    ]),
                Section::make('Bank Details')
                    ->schema([
                        Repeater::make('bankDetails')
                            ->hiddenLabel()
                            ->relationship('bankDetails')
                            ->defaultItems(0)
                            ->compact()
                            ->addActionLabel('Add Bank')
                            ->table([
                                RepeaterTableColumn::make('bank_name')->label('Bank Name')->markAsRequired()->resizable(),
                                RepeaterTableColumn::make('account_no')->label('Account No')->resizable(),
                                RepeaterTableColumn::make('ifsc_code')->label('IFSC')->resizable(),
                                RepeaterTableColumn::make('branch_name')->label('Branch')->resizable(),
                            ])
                            ->schema([
                                TextInput::make('bank_name')->label('Bank Name')->required()->maxLength(255),
                                TextInput::make('account_name')->label('Account Name')->maxLength(255),
                                TextInput::make('account_no')->label('Account No')->maxLength(50),
                                Select::make('account_type')
                                    ->label('Account Type')
                                    ->options([
                                        'Current' => 'Current',
                                        'Saving'  => 'Saving',
                                        'CC'      => 'CC',
                                        'OD'      => 'OD',
                                    ])
                                    ->native(false),
                                TextInput::make('ifsc_code')->label('IFSC Code')->maxLength(20),
                                TextInput::make('ocr_no')->label('OCR No')->maxLength(50),
                                TextInput::make('icri_number')->label('ICRI Number')->maxLength(50),
                                TextInput::make('branch_name')->label('Branch Name')->maxLength(255),
                                Textarea::make('branch_address')->label('Branch Address')->columnSpanFull(),
                                TextInput::make('branch_code')->label('Branch Code')->maxLength(50),
                                Toggle::make('is_whatsapp')->label('WhatsApp')->default(false),
                                Toggle::make('auto_mail')->label('Auto Mail')->default(false),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party_code')->label('Party Code')->searchable()->sortable(),
                TextColumn::make('party_name')->label('Party Name')->searchable()->sortable(),
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
                Section::make('Party Master')
                    ->schema([
                        TextEntry::make('company_id')->label('Company')->placeholder('-'),
                        TextEntry::make('branch_id')->label('Branch')->placeholder('-'),
                        TextEntry::make('party_code')->label('Party Code')->placeholder('-'),
                        TextEntry::make('party_name')->label('Party Name')->placeholder('-'),
                        TextEntry::make('party_type_id')->label('Party Type')->placeholder('-'),
                        TextEntry::make('party_group_id')->label('Party Group')->placeholder('-'),
                        TextEntry::make('industry_type_id')->label('Industry Type')->placeholder('-'),
                        TextEntry::make('currency_id')->label('Currency')->placeholder('-'),
                        TextEntry::make('ho_address')->label('HO Address')->placeholder('-'),
                        TextEntry::make('city_id')->label('City')->placeholder('-'),
                        TextEntry::make('state_id')->label('State')->placeholder('-'),
                        TextEntry::make('country_id')->label('Country')->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getApproveAction(): Action
    {
        return Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->visible(fn ($record): bool => blank($record?->approved_by) && auth()->user()?->can('approve_business_party_party_master'))
            ->action(function ($record): void {
                $record->forceFill([
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ])->save();

                Notification::make()
                    ->success()
                    ->title('Approved')
                    ->body('Party Master approved.')
                    ->send();
            });
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPartyMasters::route('/'),
            'create' => CreatePartyMaster::route('/create'),
            'view'   => ViewPartyMaster::route('/{record}'),
            'edit'   => EditPartyMaster::route('/{record}/edit'),
        ];
    }
}
