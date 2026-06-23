<?php

namespace Webkul\Lead\Filament\Admin\Resources;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webkul\Field\Filament\Infolists\Components\ProgressStepper as InfolistProgressStepper;
use Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages\CreateLead;
use Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages\EditLead;
use Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages\KanbanLeads;
use Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages\ListLeads;
use Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages\ViewLead;
use Webkul\Lead\Filament\Admin\Resources\LeadResource\RelationManagers\ActivitiesRelationManager;
use Webkul\Lead\Models\Lead;
use Webkul\Lead\Models\LeadActivity;
use Webkul\Sale\Filament\Clusters\Orders;
use Webkul\Security\Models\User;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $slug = 'leads';

    protected static ?int $navigationSort = 0;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $cluster = Orders::class;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $recordTitleAttribute = 'business_name';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-funnel';

    public static function getNavigationLabel(): string
    {
        return 'Leads';
    }

    public static function getNavigationGroup(): string
    {
        return __('admin.navigation.sale');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['lead_number', 'business_name', 'contact_name', 'phone', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Contact' => $record->contact_name,
            'Phone'   => $record->phone,
            'Stage'   => static::formatStage($record->stage),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Lead Progress')
                            ->schema([
                                DatePicker::make('lead_date')
                                    ->label('Lead Date')
                                    ->default(now())
                                    ->native(false)
                                    ->required(),
                                Select::make('stage')
                                    ->label('Stage')
                                    ->options(Lead::stageOptions())
                                    ->default(Lead::STAGE_NEW)
                                    ->required()
                                    ->native(false),
                                Select::make('process_status')
                                    ->label('Process Status')
                                    ->options(Lead::processStatusOptions())
                                    ->default(Lead::PROCESS_PENDING)
                                    ->required()
                                    ->native(false),
                                Select::make('progress_status')
                                    ->label('Progress Status')
                                    ->options(Lead::progressStatusOptions())
                                    ->default(Lead::PROGRESS_NEW)
                                    ->required()
                                    ->native(false),
                            ]),
                        Section::make('Business & Contact')
                            ->schema([
                                TextInput::make('business_name')
                                    ->label('Business Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus()
                                    ->extraInputAttributes(['style' => 'font-size: 1.5rem;height: 3rem;']),
                                TextInput::make('project_title')
                                    ->label('Project Title')
                                    ->maxLength(255),
                                Select::make('contact_title')
                                    ->label('Title')
                                    ->options([
                                        'Mr.'  => 'Mr.',
                                        'Mrs.' => 'Mrs.',
                                        'Ms.'  => 'Ms.',
                                    ])
                                    ->native(false),
                                TextInput::make('contact_name')
                                    ->label('Contact Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Contact No.')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('alternate_phone')
                                    ->label('Alternate No.')
                                    ->tel()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        Section::make('Address')
                            ->schema([
                                TextInput::make('address_line_1')
                                    ->label('Address 1')
                                    ->maxLength(255),
                                TextInput::make('address_line_2')
                                    ->label('Address 2')
                                    ->maxLength(255),
                                TextInput::make('city')
                                    ->maxLength(255),
                                TextInput::make('state')
                                    ->maxLength(255),
                                TextInput::make('zip')
                                    ->label('Zipcode')
                                    ->maxLength(255),
                                TextInput::make('country')
                                    ->default('India')
                                    ->maxLength(255),
                                TextInput::make('location')
                                    ->label('Location / Map Search')
                                    ->maxLength(255),
                                TextInput::make('latitude')
                                    ->numeric()
                                    ->maxValue(90)
                                    ->minValue(-90),
                                TextInput::make('longitude')
                                    ->numeric()
                                    ->maxValue(180)
                                    ->minValue(-180),
                            ])
                            ->columns(3),
                        Section::make('Site Address')
                            ->schema([
                                TextInput::make('site_contact_name')
                                    ->label('Site Contact Name')
                                    ->maxLength(255),
                                TextInput::make('site_contact_phone')
                                    ->label('Site Contact Number')
                                    ->tel()
                                    ->maxLength(255),
                                TextInput::make('site_address_line_1')
                                    ->label('Site Address 1')
                                    ->maxLength(255),
                                TextInput::make('site_address_line_2')
                                    ->label('Site Address 2')
                                    ->maxLength(255),
                                TextInput::make('site_city')
                                    ->label('Site City')
                                    ->maxLength(255),
                                TextInput::make('site_state')
                                    ->label('Site State')
                                    ->maxLength(255),
                                TextInput::make('site_zip')
                                    ->label('Site Zipcode')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->collapsible(),
                        Section::make('Remarks')
                            ->schema([
                                Textarea::make('description')
                                    ->label('Requirement')
                                    ->rows(4),
                                Textarea::make('remarks')
                                    ->rows(4),
                                TextInput::make('lost_reason')
                                    ->label('Lost Reason')
                                    ->maxLength(255)
                                    ->visible(fn (Get $get): bool => $get('stage') === Lead::STAGE_LOST),
                            ]),
                        Section::make('Products')
                            ->schema([
                                Repeater::make('products')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Product')
                                            ->maxLength(255),
                                        TextInput::make('description')
                                            ->label('Description / HSN')
                                            ->maxLength(255),
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(0),
                                        TextInput::make('uom')
                                            ->label('UOM')
                                            ->maxLength(255),
                                    ])
                                    ->columns(4)
                                    ->defaultItems(0)
                                    ->reorderable(false)
                                    ->addActionLabel('Add Product'),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Classification')
                            ->schema([
                                TextInput::make('lead_number')
                                    ->label('Lead No.')
                                    ->disabled()
                                    ->dehydrated()
                                    ->maxLength(255),
                                Select::make('business_segment')
                                    ->label('Business Segment')
                                    ->options([
                                        'Solar EPC'       => 'Solar EPC',
                                        'Solar EPC B2B'   => 'Solar EPC B2B',
                                        'Solar Pump'      => 'Solar Pump',
                                        'Product Sales'   => 'Product Sales',
                                        'Engineering'     => 'Engineering',
                                        'Manufacturing'   => 'Manufacturing',
                                        'Wind Project'    => 'Wind Project',
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->native(false),
                                TextInput::make('business_category')
                                    ->label('Business Category')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('business_sub_category')
                                    ->label('Business Sub Category')
                                    ->maxLength(255),
                                Select::make('priority')
                                    ->label('Lead Priority')
                                    ->options(Lead::priorityOptions())
                                    ->default(Lead::PRIORITY_MEDIUM)
                                    ->required()
                                    ->native(false),
                                Select::make('source')
                                    ->label('Lead Source')
                                    ->options(Lead::sourceOptions())
                                    ->searchable()
                                    ->native(false),
                                TextInput::make('other_source')
                                    ->label('Other Source')
                                    ->maxLength(255)
                                    ->disabled(fn (Get $get): bool => $get('source') !== 'other'),
                                Select::make('user_state')
                                    ->label('User State')
                                    ->options(Lead::userStateOptions())
                                    ->default(Lead::USER_STATE_ACTIVE)
                                    ->required()
                                    ->native(false),
                            ]),
                        Section::make('Opportunity')
                            ->schema([
                                TextInput::make('pv_capacity')
                                    ->label('PV Capacity (kWh)')
                                    ->numeric(),
                                TextInput::make('expected_value')
                                    ->label('Expected Value')
                                    ->numeric(),
                                TextInput::make('probability')
                                    ->label('Probability %')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->default(0),
                                DatePicker::make('expected_close_date')
                                    ->label('Expected Close Date')
                                    ->native(false),
                                DateTimePicker::make('next_follow_up_at')
                                    ->label('Next Follow Up')
                                    ->native(false),
                                TextInput::make('gst_number')
                                    ->label('GST Number')
                                    ->maxLength(255),
                                TextInput::make('territory')
                                    ->maxLength(255),
                            ]),
                        Section::make('Ownership')
                            ->schema([
                                Select::make('customer_id')
                                    ->label('Existing Customer')
                                    ->relationship('customer', 'name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('assigned_to')
                                    ->label('Sales Person')
                                    ->relationship('assignedTo', 'name')
                                    ->default(fn () => Auth::id())
                                    ->searchable()
                                    ->preload(),
                                Select::make('account_manager_id')
                                    ->label('Account Manager')
                                    ->relationship('accountManager', 'name')
                                    ->default(fn () => Auth::id())
                                    ->searchable()
                                    ->preload(),
                                Select::make('sales_person_ids')
                                    ->label('Sales Team')
                                    ->multiple()
                                    ->options(fn (): array => User::query()->pluck('name', 'id')->all())
                                    ->searchable()
                                    ->preload(),
                                Select::make('channel_partner_id')
                                    ->label('Channel Partner')
                                    ->relationship('channelPartner', 'name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('company_id')
                                    ->label('Company')
                                    ->relationship('company', 'name')
                                    ->default(fn () => Auth::user()?->default_company_id)
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Hidden::make('creator_id')
                                    ->default(fn () => Auth::id()),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderableColumns()
            ->columnManagerColumns(2)
            ->columns([
                TextColumn::make('lead_number')
                    ->label('Lead No.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('business_name')
                    ->label('Business')
                    ->description(fn (Lead $record): string => trim($record->contact_name.' | '.$record->phone, ' |'))
                    ->searchable(['business_name', 'contact_name', 'phone', 'email'])
                    ->sortable(),
                TextColumn::make('lead_date')
                    ->label('Lead Date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('business_segment')
                    ->label('Segment')
                    ->badge()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('stage')
                    ->label('Stage')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => static::formatStage($state))
                    ->color(fn (string $state): string => Lead::stageColors()[$state] ?? 'gray')
                    ->sortable(),
                TextColumn::make('process_timeline')
                    ->label('Steps')
                    ->getStateUsing(fn (Lead $record): HtmlString => static::renderStageTimeline($record))
                    ->html()
                    ->wrap(false)
                    ->visible(fn (): bool => request()->query('view') !== 'table'),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => static::formatPriority($state))
                    ->color(fn (string $state): string => Lead::priorityColors()[$state] ?? 'gray')
                    ->sortable(),
                TextColumn::make('source')
                    ->label('Source')
                    ->formatStateUsing(fn (?string $state): string => $state ? (Lead::sourceOptions()[$state] ?? str($state)->headline()->toString()) : '-')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('process_status')
                    ->label('Process')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? (Lead::processStatusOptions()[$state] ?? str($state)->headline()->toString()) : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('progress_status')
                    ->label('Progress')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => $state ? (Lead::progressStatusOptions()[$state] ?? str($state)->headline()->toString()) : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('assignedTo.name')
                    ->label('Sales Person')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('next_follow_up_at')
                    ->label('Next Follow Up')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->groups([
                Tables\Grouping\Group::make('stage')
                    ->label('Stage'),
                Tables\Grouping\Group::make('assignedTo.name')
                    ->label('Sales Person'),
            ])
            ->filters([
                SelectFilter::make('stage')
                    ->label('Stage')
                    ->options(Lead::stageOptions()),
                SelectFilter::make('priority')
                    ->label('Priority')
                    ->options(Lead::priorityOptions()),
                SelectFilter::make('assigned_to')
                    ->label('Sales Person')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('business_segment')
                    ->label('Business Segment')
                    ->options([
                        'Solar EPC'       => 'Solar EPC',
                        'Solar EPC B2B'   => 'Solar EPC B2B',
                        'Solar Pump'      => 'Solar Pump',
                        'Product Sales'   => 'Product Sales',
                        'Engineering'     => 'Engineering',
                        'Manufacturing'   => 'Manufacturing',
                        'Wind Project'    => 'Wind Project',
                    ]),
                SelectFilter::make('source')
                    ->label('Lead Source')
                    ->options(Lead::sourceOptions()),
                SelectFilter::make('process_status')
                    ->label('Process Status')
                    ->options(Lead::processStatusOptions()),
                SelectFilter::make('progress_status')
                    ->label('Progress Status')
                    ->options(Lead::progressStatusOptions()),
                SelectFilter::make('user_state')
                    ->label('User State')
                    ->options(Lead::userStateOptions()),
                Filter::make('lead_date')
                    ->label('Lead Date')
                    ->schema([
                        DatePicker::make('from')
                            ->label('From')
                            ->native(false),
                        DatePicker::make('until')
                            ->label('To')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('lead_date', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('lead_date', '<=', $date));
                    }),
                Filter::make('location')
                    ->schema([
                        TextInput::make('location')
                            ->label('Location'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['location'] ?? null, function (Builder $query, string $location): Builder {
                            return $query->where(function (Builder $query) use ($location): void {
                                $query
                                    ->where('location', 'like', "%{$location}%")
                                    ->orWhere('city', 'like', "%{$location}%")
                                    ->orWhere('state', 'like', "%{$location}%")
                                    ->orWhere('country', 'like', "%{$location}%");
                            });
                        });
                    }),
                Filter::make('overdue_follow_up')
                    ->label('Overdue Follow Up')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('next_follow_up_at')->where('next_follow_up_at', '<', now())),
            ], layout: FiltersLayout::Modal)
            ->filtersFormColumns(3)
            ->filtersTriggerAction(
                fn (Action $action) => $action
                    ->label('Search / Filters')
                    ->icon('heroicon-o-magnifying-glass')
                    ->slideOver(),
            )
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    static::changeStageAction(),
                    static::addNoteAction(),
                    static::quickTaskAction(),
                    static::logCallAction(),
                    static::sendEmailAction(),
                    static::openMapAction(),
                    static::copyLeadAction(),
                    static::convertToQuotationAction(),
                    static::convertToOrderAction(),
                    static::createCostingAction(),
                    RestoreAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    static::bulkUpdateAction(),
                    RestoreBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        InfolistProgressStepper::make('stage')
                            ->hiddenLabel()
                            ->inline()
                            ->options(Lead::stageOptions()),
                        Section::make('Lead')
                            ->schema([
                                TextEntry::make('lead_number')
                                    ->label('Lead No.')
                                    ->badge(),
                                TextEntry::make('lead_date')
                                    ->label('Lead Date')
                                    ->date(),
                                TextEntry::make('business_name')
                                    ->label('Business')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('project_title')
                                    ->label('Project Title')
                                    ->placeholder('-'),
                                TextEntry::make('description')
                                    ->label('Requirement')
                                    ->placeholder('-'),
                                TextEntry::make('remarks')
                                    ->placeholder('-'),
                            ]),
                        Section::make('Contact & Address')
                            ->schema([
                                TextEntry::make('contact_name')
                                    ->label('Contact'),
                                TextEntry::make('phone')
                                    ->label('Contact No.'),
                                TextEntry::make('email')
                                    ->placeholder('-'),
                                TextEntry::make('address_line_1')
                                    ->label('Address 1')
                                    ->placeholder('-'),
                                TextEntry::make('location')
                                    ->placeholder('-'),
                                TextEntry::make('map_url')
                                    ->label('Map')
                                    ->url(fn (?string $state): ?string => $state)
                                    ->openUrlInNewTab()
                                    ->formatStateUsing(fn (?string $state): string => $state ? 'Open in Google Maps' : '-'),
                                TextEntry::make('city')
                                    ->placeholder('-'),
                                TextEntry::make('state')
                                    ->placeholder('-'),
                            ])
                            ->columns(2),
                        Section::make('Products')
                            ->schema([
                                TextEntry::make('products')
                                    ->hiddenLabel()
                                    ->formatStateUsing(function (?array $state): string {
                                        if (blank($state)) {
                                            return '-';
                                        }

                                        return collect($state)
                                            ->map(function (array $product): string {
                                                return trim(($product['name'] ?? 'Product').' | Qty: '.($product['quantity'] ?? 1).' '.($product['uom'] ?? ''), ' |');
                                            })
                                            ->implode("\n");
                                    })
                                    ->listWithLineBreaks(),
                            ])
                            ->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                TextEntry::make('stage')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => static::formatStage($state))
                                    ->color(fn (string $state): string => Lead::stageColors()[$state] ?? 'gray'),
                                TextEntry::make('priority')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => static::formatPriority($state))
                                    ->color(fn (string $state): string => Lead::priorityColors()[$state] ?? 'gray'),
                                TextEntry::make('process_status')
                                    ->label('Process')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => $state ? (Lead::processStatusOptions()[$state] ?? str($state)->headline()->toString()) : '-'),
                                TextEntry::make('progress_status')
                                    ->label('Progress')
                                    ->badge()
                                    ->formatStateUsing(fn (?string $state): string => $state ? (Lead::progressStatusOptions()[$state] ?? str($state)->headline()->toString()) : '-'),
                                TextEntry::make('business_segment')
                                    ->label('Segment')
                                    ->placeholder('-'),
                                TextEntry::make('source')
                                    ->formatStateUsing(fn (?string $state): string => $state ? (Lead::sourceOptions()[$state] ?? str($state)->headline()->toString()) : '-'),
                            ]),
                        Section::make('Opportunity')
                            ->schema([
                                TextEntry::make('pv_capacity')
                                    ->label('PV Capacity')
                                    ->placeholder('-'),
                                TextEntry::make('expected_value')
                                    ->money('INR')
                                    ->placeholder('-'),
                                TextEntry::make('probability')
                                    ->suffix('%'),
                                TextEntry::make('expected_close_date')
                                    ->date()
                                    ->placeholder('-'),
                                TextEntry::make('next_follow_up_at')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                        Section::make('Ownership')
                            ->schema([
                                TextEntry::make('assignedTo.name')
                                    ->label('Sales Person')
                                    ->placeholder('-'),
                                TextEntry::make('accountManager.name')
                                    ->label('Account Manager')
                                    ->placeholder('-'),
                                TextEntry::make('channelPartner.name')
                                    ->label('Channel Partner')
                                    ->placeholder('-'),
                                TextEntry::make('territory')
                                    ->placeholder('-'),
                                TextEntry::make('company.name')
                                    ->label('Company'),
                                TextEntry::make('creator.name')
                                    ->label('Created By'),
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewLead::class,
            EditLead::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListLeads::route('/'),
            'kanban' => KanbanLeads::route('/kanban'),
            'create' => CreateLead::route('/create'),
            'view'   => ViewLead::route('/{record}'),
            'edit'   => EditLead::route('/{record}/edit'),
        ];
    }

    public static function changeStageAction(): Action
    {
        return Action::make('change_stage')
            ->label('Change Stage')
            ->icon('heroicon-o-arrow-path')
            ->schema([
                Select::make('stage')
                    ->label('Stage')
                    ->options(Lead::stageOptions())
                    ->required()
                    ->native(false),
                TextInput::make('lost_reason')
                    ->label('Lost Reason')
                    ->maxLength(255),
            ])
            ->fillForm(fn (Lead $record): array => [
                'stage'       => $record->stage,
                'lost_reason' => $record->lost_reason,
            ])
            ->action(function (Lead $record, array $data): void {
                $isClosedWon = $data['stage'] === Lead::STAGE_WON;
                $isClosedLost = in_array($data['stage'], [Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED], true);

                $record->update([
                    'stage'           => $data['stage'],
                    'lost_reason'     => $isClosedLost ? ($data['lost_reason'] ?? null) : null,
                    'process_status'  => ($isClosedWon || $isClosedLost) ? Lead::PROCESS_COMPLETED : Lead::PROCESS_IN_PROGRESS,
                    'progress_status' => match (true) {
                        $isClosedWon  => Lead::PROGRESS_CLOSE_WON,
                        $isClosedLost => Lead::PROGRESS_CLOSE_LOST,
                        default       => Lead::PROGRESS_IN_PROGRESS,
                    },
                ]);

                $record->activities()->create([
                    'type'    => LeadActivity::TYPE_NOTE,
                    'subject' => 'Stage changed to '.static::formatStage($data['stage']),
                ]);

                Notification::make()
                    ->success()
                    ->title('Lead stage updated')
                    ->body('The lead stage has been changed successfully.')
                    ->send();
            });
    }

    public static function logCallAction(): Action
    {
        return Action::make('log_call')
            ->label('Log Call')
            ->icon('heroicon-o-phone')
            ->schema([
                TextInput::make('subject')
                    ->label('Subject')
                    ->default('Call logged')
                    ->required()
                    ->maxLength(255),
                Textarea::make('body')
                    ->label('Notes')
                    ->rows(4),
                DateTimePicker::make('next_follow_up_at')
                    ->label('Next Follow Up')
                    ->native(false),
            ])
            ->action(function (Lead $record, array $data): void {
                $record->activities()->create([
                    'type'    => LeadActivity::TYPE_CALL,
                    'subject' => $data['subject'],
                    'body'    => $data['body'] ?? null,
                ]);

                $record->update([
                    'last_contacted_at' => now(),
                    'next_follow_up_at' => $data['next_follow_up_at'] ?? $record->next_follow_up_at,
                ]);

                Notification::make()
                    ->success()
                    ->title('Call logged')
                    ->body('The call note has been saved on this lead.')
                    ->send();
            });
    }

    public static function addNoteAction(): Action
    {
        return Action::make('add_note')
            ->label('Add Note')
            ->icon('heroicon-o-chat-bubble-left-right')
            ->schema([
                TextInput::make('subject')
                    ->default('Lead note')
                    ->required()
                    ->maxLength(255),
                Textarea::make('body')
                    ->label('Note')
                    ->rows(4)
                    ->required(),
            ])
            ->action(function (Lead $record, array $data): void {
                $record->activities()->create([
                    'type'    => LeadActivity::TYPE_NOTE,
                    'subject' => $data['subject'],
                    'body'    => $data['body'],
                ]);

                Notification::make()
                    ->success()
                    ->title('Note added')
                    ->body('The note has been saved on this lead.')
                    ->send();
            });
    }

    public static function quickTaskAction(): Action
    {
        return Action::make('quick_task')
            ->label('Quick Task')
            ->icon('heroicon-o-clipboard-document-list')
            ->schema([
                TextInput::make('subject')
                    ->label('Task')
                    ->required()
                    ->maxLength(255),
                Select::make('assigned_to')
                    ->label('Assign To')
                    ->options(fn (): array => User::query()->pluck('name', 'id')->all())
                    ->default(fn (Lead $record): ?int => $record->assigned_to)
                    ->searchable(),
                DateTimePicker::make('next_follow_up_at')
                    ->label('Due / Follow Up')
                    ->native(false),
                Select::make('priority')
                    ->options(Lead::priorityOptions())
                    ->native(false),
                Textarea::make('body')
                    ->label('Description')
                    ->rows(3),
            ])
            ->action(function (Lead $record, array $data): void {
                $record->activities()->create([
                    'type'        => LeadActivity::TYPE_TASK,
                    'subject'     => $data['subject'],
                    'body'        => $data['body'] ?? null,
                    'activity_at' => $data['next_follow_up_at'] ?? now(),
                ]);

                $record->update([
                    'assigned_to'       => $data['assigned_to'] ?? $record->assigned_to,
                    'priority'          => $data['priority'] ?? $record->priority,
                    'next_follow_up_at' => $data['next_follow_up_at'] ?? $record->next_follow_up_at,
                ]);

                Notification::make()
                    ->success()
                    ->title('Task created')
                    ->body('The quick task has been saved on this lead.')
                    ->send();
            });
    }

    public static function sendEmailAction(): Action
    {
        return Action::make('send_email')
            ->label('Send Email')
            ->icon('heroicon-o-envelope')
            ->url(fn (Lead $record): ?string => $record->email ? 'mailto:'.$record->email : null)
            ->openUrlInNewTab()
            ->visible(fn (Lead $record): bool => filled($record->email));
    }

    public static function openMapAction(): Action
    {
        return Action::make('open_map')
            ->label('Open Map')
            ->icon('heroicon-o-map-pin')
            ->url(fn (Lead $record): ?string => $record->map_url)
            ->openUrlInNewTab()
            ->visible(fn (Lead $record): bool => filled($record->map_url));
    }

    public static function copyLeadAction(): Action
    {
        return Action::make('copy_lead')
            ->label('Copy Lead')
            ->icon('heroicon-o-document-duplicate')
            ->requiresConfirmation()
            ->action(function (Lead $record): void {
                $copy = $record->replicate(['lead_number']);
                $copy->business_name = $record->business_name.' (Copy)';
                $copy->stage = Lead::STAGE_NEW;
                $copy->progress_status = Lead::PROGRESS_NEW;
                $copy->process_status = Lead::PROCESS_PENDING;
                $copy->lead_date = now()->toDateString();
                $copy->save();

                $copy->activities()->create([
                    'type'    => LeadActivity::TYPE_NOTE,
                    'subject' => 'Copied from '.$record->lead_number,
                ]);

                Notification::make()
                    ->success()
                    ->title('Lead copied')
                    ->body($copy->lead_number.' has been created.')
                    ->send();
            });
    }

    public static function convertToQuotationAction(): Action
    {
        return static::workflowAction(
            name: 'convert_to_quotation',
            label: 'Convert To Quotation',
            icon: 'heroicon-o-document-text',
            stage: Lead::STAGE_QUOTATION,
            subject: 'Marked for quotation'
        );
    }

    public static function convertToOrderAction(): Action
    {
        return static::workflowAction(
            name: 'convert_to_customer_order',
            label: 'Convert To Customer Order',
            icon: 'heroicon-o-shopping-cart',
            stage: Lead::STAGE_WON,
            subject: 'Marked for customer order'
        );
    }

    public static function createCostingAction(): Action
    {
        return static::workflowAction(
            name: 'create_costing',
            label: 'Create Costing',
            icon: 'heroicon-o-calculator',
            stage: Lead::STAGE_DESIGN,
            subject: 'Costing requested'
        );
    }

    public static function bulkUpdateAction(): BulkAction
    {
        return BulkAction::make('bulk_update')
            ->label('Bulk Update')
            ->icon('heroicon-o-pencil-square')
            ->schema([
                Select::make('stage')
                    ->options(Lead::stageOptions())
                    ->native(false),
                Select::make('priority')
                    ->options(Lead::priorityOptions())
                    ->native(false),
                Select::make('assigned_to')
                    ->label('Sales Person')
                    ->options(fn (): array => User::query()->pluck('name', 'id')->all())
                    ->searchable(),
                Select::make('process_status')
                    ->label('Process Status')
                    ->options(Lead::processStatusOptions())
                    ->native(false),
                Select::make('progress_status')
                    ->label('Progress Status')
                    ->options(Lead::progressStatusOptions())
                    ->native(false),
                DateTimePicker::make('next_follow_up_at')
                    ->label('Next Follow Up')
                    ->native(false),
            ])
            ->action(function (Collection $records, array $data): void {
                $payload = collect($data)
                    ->filter(fn ($value): bool => filled($value))
                    ->all();

                if (blank($payload)) {
                    Notification::make()
                        ->warning()
                        ->title('Nothing to update')
                        ->body('Choose at least one field before running bulk update.')
                        ->send();

                    return;
                }

                $records->each(function (Lead $record) use ($payload): void {
                    $record->update($payload);

                    if (array_key_exists('stage', $payload)) {
                        $record->activities()->create([
                            'type'    => LeadActivity::TYPE_NOTE,
                            'subject' => 'Bulk stage changed to '.static::formatStage($payload['stage']),
                        ]);
                    }
                });

                Notification::make()
                    ->success()
                    ->title('Leads updated')
                    ->body($records->count().' selected lead(s) were updated.')
                    ->send();
            })
            ->deselectRecordsAfterCompletion();
    }

    protected static function workflowAction(string $name, string $label, string $icon, string $stage, string $subject): Action
    {
        return Action::make($name)
            ->label($label)
            ->icon($icon)
            ->requiresConfirmation()
            ->action(function (Lead $record) use ($stage, $subject): void {
                $record->update([
                    'stage'           => $stage,
                    'progress_status' => $stage === Lead::STAGE_WON ? Lead::PROGRESS_CLOSE_WON : $record->progress_status,
                    'process_status'  => $stage === Lead::STAGE_WON ? Lead::PROCESS_COMPLETED : Lead::PROCESS_IN_PROGRESS,
                ]);

                $record->activities()->create([
                    'type'    => LeadActivity::TYPE_NOTE,
                    'subject' => $subject,
                ]);

                Notification::make()
                    ->success()
                    ->title('Lead updated')
                    ->body($subject.' for '.$record->lead_number.'.')
                    ->send();
            });
    }

    public static function dataActions(): ActionGroup
    {
        return ActionGroup::make([
            static::importCsvAction(),
            static::exportCsvAction(),
        ])
            ->label('Data')
            ->icon('heroicon-o-arrow-down-tray');
    }

    public static function reportActions(): ActionGroup
    {
        return ActionGroup::make([
            static::summaryReportAction('stage_summary', 'Lead Summary Status Wise', 'stage', Lead::stageOptions()),
            static::summaryReportAction('priority_summary', 'Lead Status Priority Wise', 'priority', Lead::priorityOptions()),
            static::summaryReportAction('source_summary', 'Lead Status Source Wise', 'source', Lead::sourceOptions()),
            static::ownerReportAction(),
            static::monthReportAction(),
            static::callLogReportAction(),
        ])
            ->label('Reports')
            ->icon('heroicon-o-chart-bar');
    }

    public static function viewModeActions(): ActionGroup
    {
        return ActionGroup::make([
            Action::make('normal_view')
                ->label('Normal')
                ->icon('heroicon-o-list-bullet')
                ->url(fn (): string => static::getUrl('index')),
            Action::make('table_view')
                ->label('Table')
                ->icon('heroicon-o-table-cells')
                ->url(fn (): string => static::getUrl('index').'?view=table'),
            Action::make('kanban_view')
                ->label('Kanban')
                ->icon('heroicon-o-view-columns')
                ->url(fn (): string => static::getUrl('kanban')),
        ])
            ->label('Views')
            ->icon('heroicon-o-squares-2x2');
    }

    public static function importCsvAction(): Action
    {
        return Action::make('import_csv')
            ->label('Import')
            ->icon('heroicon-o-arrow-up-tray')
            ->schema([
                Textarea::make('csv')
                    ->label('CSV data')
                    ->helperText('First row must be headers. Supported headers: business_name, contact_name, phone, email, stage, priority, source, city, state, location.')
                    ->rows(12)
                    ->required(),
            ])
            ->action(function (array $data): void {
                $rows = collect(preg_split('/\r\n|\r|\n/', trim($data['csv'] ?? '')))
                    ->filter()
                    ->values();

                if ($rows->count() < 2) {
                    Notification::make()
                        ->danger()
                        ->title('Import failed')
                        ->body('Paste a header row and at least one lead row.')
                        ->send();

                    return;
                }

                $headers = collect(str_getcsv($rows->shift()))
                    ->map(fn (string $header): string => str($header)->snake()->toString())
                    ->all();

                $created = 0;

                $rows->each(function (string $row) use ($headers, &$created): void {
                    $values = str_getcsv($row);
                    $payload = array_combine($headers, array_pad($values, count($headers), null));

                    if (blank($payload['business_name'] ?? null) || blank($payload['contact_name'] ?? null) || blank($payload['phone'] ?? null)) {
                        return;
                    }

                    Lead::query()->create([
                        'business_name'     => $payload['business_name'],
                        'contact_name'      => $payload['contact_name'],
                        'phone'             => $payload['phone'],
                        'email'             => $payload['email'] ?? null,
                        'stage'             => $payload['stage'] ?? Lead::STAGE_NEW,
                        'priority'          => $payload['priority'] ?? Lead::PRIORITY_MEDIUM,
                        'source'            => $payload['source'] ?? null,
                        'business_segment'  => $payload['business_segment'] ?? null,
                        'business_category' => $payload['business_category'] ?? null,
                        'city'              => $payload['city'] ?? null,
                        'state'             => $payload['state'] ?? null,
                        'location'          => $payload['location'] ?? null,
                    ]);

                    $created++;
                });

                Notification::make()
                    ->success()
                    ->title('Import complete')
                    ->body($created.' lead(s) were imported.')
                    ->send();
            });
    }

    public static function exportCsvAction(): Action
    {
        return Action::make('export_csv')
            ->label('Export')
            ->icon('heroicon-o-arrow-down-tray')
            ->action(fn (): StreamedResponse => static::downloadLeadCsv());
    }

    protected static function summaryReportAction(string $name, string $label, string $column, array $labels): Action
    {
        return Action::make($name)
            ->label($label)
            ->icon('heroicon-o-document-chart-bar')
            ->action(function () use ($label, $column, $labels): StreamedResponse {
                $rows = Lead::query()
                    ->selectRaw($column.' as bucket, count(*) as leads_count')
                    ->groupBy($column)
                    ->orderBy($column)
                    ->get()
                    ->map(fn (Lead $lead): array => [
                        'Name'  => $labels[$lead->bucket] ?? ($lead->bucket ? str($lead->bucket)->headline()->toString() : 'Blank'),
                        'Count' => $lead->leads_count,
                    ]);

                return static::downloadRows(str($label)->slug('_')->append('.csv')->toString(), ['Name', 'Count'], $rows);
            });
    }

    protected static function ownerReportAction(): Action
    {
        return Action::make('employee_summary')
            ->label('Lead Status Employee Wise')
            ->icon('heroicon-o-users')
            ->action(function (): StreamedResponse {
                $rows = Lead::query()
                    ->with('assignedTo')
                    ->get()
                    ->groupBy(fn (Lead $lead): string => $lead->assignedTo?->name ?: 'Unassigned')
                    ->map(fn (Collection $leads, string $owner): array => [
                        'Owner' => $owner,
                        'Open'  => $leads->whereNotIn('stage', [Lead::STAGE_WON, Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED])->count(),
                        'Won'   => $leads->where('stage', Lead::STAGE_WON)->count(),
                        'Lost'  => $leads->whereIn('stage', [Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED])->count(),
                        'Total' => $leads->count(),
                    ])
                    ->values();

                return static::downloadRows('lead_status_employee_wise.csv', ['Owner', 'Open', 'Won', 'Lost', 'Total'], $rows);
            });
    }

    protected static function monthReportAction(): Action
    {
        return Action::make('month_summary')
            ->label('Lead Status Month Wise')
            ->icon('heroicon-o-calendar-days')
            ->action(function (): StreamedResponse {
                $rows = Lead::query()
                    ->get()
                    ->groupBy(fn (Lead $lead): string => ($lead->lead_date ?: $lead->created_at)->format('Y-m'))
                    ->map(fn (Collection $leads, string $month): array => [
                        'Month' => $month,
                        'Open'  => $leads->whereNotIn('stage', [Lead::STAGE_WON, Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED])->count(),
                        'Won'   => $leads->where('stage', Lead::STAGE_WON)->count(),
                        'Lost'  => $leads->whereIn('stage', [Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED])->count(),
                        'Total' => $leads->count(),
                    ])
                    ->values();

                return static::downloadRows('lead_status_month_wise.csv', ['Month', 'Open', 'Won', 'Lost', 'Total'], $rows);
            });
    }

    protected static function callLogReportAction(): Action
    {
        return Action::make('call_log_report')
            ->label('Call Log Report')
            ->icon('heroicon-o-phone')
            ->action(function (): StreamedResponse {
                $rows = LeadActivity::query()
                    ->with(['lead', 'creator'])
                    ->where('type', LeadActivity::TYPE_CALL)
                    ->latest('activity_at')
                    ->get()
                    ->map(fn (LeadActivity $activity): array => [
                        'Lead No.'     => $activity->lead?->lead_number,
                        'Business'     => $activity->lead?->business_name,
                        'Subject'      => $activity->subject,
                        'Notes'        => $activity->body,
                        'Activity At'  => $activity->activity_at?->toDateTimeString(),
                        'Logged By'    => $activity->creator?->name,
                    ]);

                return static::downloadRows('lead_call_log_report.csv', ['Lead No.', 'Business', 'Subject', 'Notes', 'Activity At', 'Logged By'], $rows);
            });
    }

    protected static function downloadLeadCsv(): StreamedResponse
    {
        $rows = Lead::query()
            ->with(['assignedTo', 'accountManager', 'channelPartner'])
            ->latest('lead_date')
            ->get()
            ->map(fn (Lead $lead): array => [
                'Lead No.'         => $lead->lead_number,
                'Lead Date'        => $lead->lead_date?->toDateString(),
                'Business'         => $lead->business_name,
                'Contact'          => $lead->contact_name,
                'Phone'            => $lead->phone,
                'Email'            => $lead->email,
                'Stage'            => static::formatStage($lead->stage),
                'Priority'         => static::formatPriority($lead->priority),
                'Source'           => $lead->source ? (Lead::sourceOptions()[$lead->source] ?? $lead->source) : null,
                'Segment'          => $lead->business_segment,
                'Category'         => $lead->business_category,
                'Location'         => $lead->location ?: $lead->full_address,
                'Sales Person'     => $lead->assignedTo?->name,
                'Account Manager'  => $lead->accountManager?->name,
                'Channel Partner'  => $lead->channelPartner?->name,
                'Expected Value'   => $lead->expected_value,
                'Next Follow Up'   => $lead->next_follow_up_at?->toDateTimeString(),
            ]);

        return static::downloadRows('leads.csv', [
            'Lead No.',
            'Lead Date',
            'Business',
            'Contact',
            'Phone',
            'Email',
            'Stage',
            'Priority',
            'Source',
            'Segment',
            'Category',
            'Location',
            'Sales Person',
            'Account Manager',
            'Channel Partner',
            'Expected Value',
            'Next Follow Up',
        ], $rows);
    }

    protected static function downloadRows(string $fileName, array $headers, Collection $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            $rows->each(function (array $row) use ($handle, $headers): void {
                fputcsv($handle, collect($headers)->map(fn (string $header) => $row[$header] ?? null)->all());
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public static function renderStageTimeline(Lead $record): HtmlString
    {
        $stages = static::timelineStages();
        $currentIndex = array_search($record->stage, array_keys($stages), true);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;

        $items = collect($stages)
            ->map(function (string $label, string $stage) use ($record, $currentIndex, $stages): string {
                $index = array_search($stage, array_keys($stages), true);
                $isDone = $index < $currentIndex;
                $isCurrent = $stage === $record->stage;
                $dotClass = $isCurrent
                    ? 'background:#16a34a;border-color:#16a34a;color:#fff;'
                    : ($isDone ? 'background:#22c55e;border-color:#22c55e;color:#fff;' : 'background:#fff;border-color:#cbd5e1;color:#64748b;');
                $lineClass = $isDone ? 'background:#22c55e;' : 'background:#cbd5e1;';
                $icon = $isCurrent || $isDone ? '&#10003;' : '!';

                return '<div style="display:flex;align-items:center;min-width:84px;flex:1;">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:3px;width:70px;">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:17px;height:17px;border:1px solid;border-radius:999px;font-size:10px;font-weight:700;'.$dotClass.'">'.$icon.'</span>
                        <span style="font-size:10px;line-height:1;color:#475569;white-space:nowrap;">'.e($label).'</span>
                    </div>
                    <span style="height:1px;flex:1;'.$lineClass.'"></span>
                </div>';
            })
            ->implode('');

        return new HtmlString('<div style="min-width:760px;max-width:920px;display:flex;align-items:flex-start;padding-top:2px;">'.$items.'</div>');
    }

    public static function timelineStages(): array
    {
        return [
            Lead::STAGE_NEW            => 'New',
            Lead::STAGE_QUOTATION      => 'Quotation',
            Lead::STAGE_QUALIFIED      => 'Qualified',
            Lead::STAGE_SITE_SURVEY    => 'Site Survey',
            Lead::STAGE_DESIGN         => 'Design',
            Lead::STAGE_SENT           => 'Sent',
            Lead::STAGE_DISQUALIFIED   => 'Disqualified',
            Lead::STAGE_MEETING_DONE   => 'Meeting Done',
            Lead::STAGE_AGREEMENT_DONE => 'Agreement Done',
            Lead::STAGE_WON            => 'Won',
            Lead::STAGE_LOST           => 'Lost',
        ];
    }

    protected static function formatStage(string $stage): string
    {
        return Lead::stageOptions()[$stage] ?? str($stage)->headline()->toString();
    }

    protected static function formatPriority(string $priority): string
    {
        return Lead::priorityOptions()[$priority] ?? str($priority)->headline()->toString();
    }
}
