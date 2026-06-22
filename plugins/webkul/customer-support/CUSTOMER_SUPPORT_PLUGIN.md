# Customer Support Plugin Full Output

Plugin name: `customer-support`

Install command:

```bash
php artisan customer-support:install
```

This document contains the full generated source for the AureusERP customer support plugin.

## plugins/webkul/customer-support/composer.json

`$language
{
    "name": "webkul/customer-support",
    "description": "Manage customer support tickets",
    "authors": [
        {
            "name": "Aureus ERP",
            "email": "support@aureuserp.in"
        }
    ],
    "extra": {
        "laravel": {
            "providers": [
                "Webkul\\CustomerSupport\\CustomerSupportServiceProvider"
            ],
            "aliases": {}
        }
    },
    "autoload": {
        "psr-4": {
            "Webkul\\CustomerSupport\\": "src/",
            "Webkul\\CustomerSupport\\Database\\Factories\\": "database/factories/",
            "Webkul\\CustomerSupport\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Webkul\\CustomerSupport\\Tests\\": "tests/"
        }
    }
}
```

## plugins/webkul/customer-support/src/CustomerSupportServiceProvider.php

`$language
<?php

namespace Webkul\CustomerSupport;

use Filament\Panel;
use Webkul\PluginManager\Console\Commands\InstallCommand;
use Webkul\PluginManager\Console\Commands\UninstallCommand;
use Webkul\PluginManager\Package;
use Webkul\PluginManager\PackageServiceProvider;

class CustomerSupportServiceProvider extends PackageServiceProvider
{
    public static string $name = 'customer-support';

    public static string $viewNamespace = 'customer-support';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2026_01_01_000001_create_customer_support_tickets_table',
            ])
            ->runsMigrations()
            ->hasSettings([
            ])
            ->runsSettings()
            ->hasDependencies([
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->runsMigrations();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('heroicon-o-lifebuoy');
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            $panel->plugin(CustomerSupportPlugin::make());
        });
    }
}
```

## plugins/webkul/customer-support/src/CustomerSupportPlugin.php

`$language
<?php

namespace Webkul\CustomerSupport;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Webkul\PluginManager\Package;

class CustomerSupportPlugin implements Plugin
{
    public function getId(): string
    {
        return 'customer-support';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        if (! Package::isPluginInstalled($this->getId())) {
            return;
        }

        $panel
            ->when($panel->getId() == 'customer', function (Panel $panel) {
                $panel
                    ->discoverResources(
                        in: __DIR__.'/Filament/Customer/Resources',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Resources'
                    )
                    ->discoverPages(
                        in: __DIR__.'/Filament/Customer/Pages',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Pages'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Customer/Clusters',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Clusters'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Customer/Widgets',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Widgets'
                    );
            })
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel
                    ->discoverResources(
                        in: __DIR__.'/Filament/Admin/Resources',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Resources'
                    )
                    ->discoverPages(
                        in: __DIR__.'/Filament/Admin/Pages',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Pages'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Admin/Clusters',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Clusters'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Admin/Widgets',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Widgets'
                    );
            });
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
```

## plugins/webkul/customer-support/src/Models/Ticket.php

`$language
<?php

namespace Webkul\CustomerSupport\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Webkul\Partner\Models\Partner;
use Webkul\Security\Models\User;
use Webkul\Support\Models\Company;

class Ticket extends Model
{
    use HasUlids;

    public const STATUS_OPEN = 'open';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_RESOLVED = 'resolved';

    public const STATUS_CLOSED = 'closed';

    public const PRIORITY_LOW = 'low';

    public const PRIORITY_MEDIUM = 'medium';

    public const PRIORITY_HIGH = 'high';

    public const PRIORITY_URGENT = 'urgent';

    protected $table = 'customer_support_tickets';

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'customer_id',
        'assigned_to',
        'resolved_at',
        'company_id',
        'creator_id',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_OPEN        => 'Open',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_RESOLVED    => 'Resolved',
            self::STATUS_CLOSED      => 'Closed',
        ];
    }

    public static function statusColors(): array
    {
        return [
            self::STATUS_OPEN        => 'info',
            self::STATUS_IN_PROGRESS => 'warning',
            self::STATUS_RESOLVED    => 'success',
            self::STATUS_CLOSED      => 'gray',
        ];
    }

    public static function priorityOptions(): array
    {
        return [
            self::PRIORITY_LOW    => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH   => 'High',
            self::PRIORITY_URGENT => 'Urgent',
        ];
    }

    public static function priorityColors(): array
    {
        return [
            self::PRIORITY_LOW    => 'gray',
            self::PRIORITY_MEDIUM => 'info',
            self::PRIORITY_HIGH   => 'warning',
            self::PRIORITY_URGENT => 'danger',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'customer_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Ticket $ticket) {
            $authUser = Auth::user();

            $ticket->status ??= self::STATUS_OPEN;
            $ticket->priority ??= self::PRIORITY_MEDIUM;
            $ticket->creator_id ??= $authUser?->id;
            $ticket->company_id ??= $authUser?->default_company_id;
        });

        static::saving(function (Ticket $ticket) {
            if (in_array($ticket->status, [self::STATUS_RESOLVED, self::STATUS_CLOSED]) && ! $ticket->resolved_at) {
                $ticket->resolved_at = now();
            }
        });
    }
}
```

## plugins/webkul/customer-support/src/Policies/TicketPolicy.php

`$language
<?php

namespace Webkul\CustomerSupport\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webkul\CustomerSupport\Models\Ticket;
use Webkul\Security\Models\User;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_customer_support_ticket');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->can('view_customer_support_ticket');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_customer_support_ticket');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->can('update_customer_support_ticket');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->can('delete_customer_support_ticket');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_customer_support_ticket');
    }
}
```

## plugins/webkul/customer-support/database/migrations/2026_01_01_000001_create_customer_support_tickets_table.php

`$language
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_support_tickets', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('partners_partners')
                ->nullOnDelete();

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('resolved_at')->nullable();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->restrictOnDelete();

            $table->foreignId('creator_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_support_tickets');
    }
};
```

## plugins/webkul/customer-support/src/Filament/Admin/Resources/TicketResource.php

`$language
<?php

namespace Webkul\CustomerSupport\Filament\Admin\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
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
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages\CreateTicket;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages\EditTicket;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages\ListTickets;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages\ViewTicket;
use Webkul\CustomerSupport\Models\Ticket;
use Webkul\Field\Filament\Infolists\Components\ProgressStepper as InfolistProgressStepper;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $slug = 'customer-support/tickets';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationLabel(): string
    {
        return 'Tickets';
    }

    public static function getNavigationGroup(): string
    {
        return 'Customer Support';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'customer.name', 'assignedTo.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Customer' => $record->customer?->name ?? '-',
            'Assigned' => $record->assignedTo?->name ?? '-',
            'Status'   => static::formatStatus($record->status),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Ticket')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus()
                                    ->extraInputAttributes(['style' => 'font-size: 1.5rem;height: 3rem;']),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Classification')
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options(Ticket::statusOptions())
                                    ->default(Ticket::STATUS_OPEN)
                                    ->required()
                                    ->native(false),
                                Select::make('priority')
                                    ->label('Priority')
                                    ->options(Ticket::priorityOptions())
                                    ->default(Ticket::PRIORITY_MEDIUM)
                                    ->required()
                                    ->native(false),
                                DateTimePicker::make('resolved_at')
                                    ->label('Resolved At')
                                    ->native(false),
                            ]),
                        Section::make('Ownership')
                            ->schema([
                                Select::make('customer_id')
                                    ->label('Customer')
                                    ->relationship('customer', 'name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('assigned_to')
                                    ->label('Assigned To')
                                    ->relationship('assignedTo', 'name')
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
                    ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderableColumns()
            ->columnManagerColumns(2)
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => static::formatStatus($state))
                    ->color(fn (string $state): string => Ticket::statusColors()[$state] ?? 'gray')
                    ->sortable(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => static::formatPriority($state))
                    ->color(fn (string $state): string => Ticket::priorityColors()[$state] ?? 'gray')
                    ->sortable(),
                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(Ticket::statusOptions()),
                SelectFilter::make('priority')
                    ->label('Priority')
                    ->options(Ticket::priorityOptions()),
                SelectFilter::make('assigned_to')
                    ->label('Assigned To')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('change_status')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->options(Ticket::statusOptions())
                                ->required()
                                ->native(false),
                        ])
                        ->fillForm(fn (Ticket $record): array => [
                            'status' => $record->status,
                        ])
                        ->action(function (Ticket $record, array $data): void {
                            $record->update([
                                'status'      => $data['status'],
                                'resolved_at' => in_array($data['status'], [Ticket::STATUS_RESOLVED, Ticket::STATUS_CLOSED]) ? ($record->resolved_at ?? now()) : null,
                            ]);

                            Notification::make()
                                ->success()
                                ->title('Ticket status updated')
                                ->body('The ticket status has been changed successfully.')
                                ->send();
                        }),
                    DeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Ticket deleted')
                                ->body('The ticket has been deleted successfully.'),
                        ),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Tickets deleted')
                                ->body('The selected tickets have been deleted successfully.'),
                        ),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        InfolistProgressStepper::make('status')
                            ->hiddenLabel()
                            ->inline()
                            ->options(Ticket::statusOptions()),
                        Section::make('Ticket')
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Title')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('description')
                                    ->label('Description')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Classification')
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => static::formatStatus($state))
                                    ->color(fn (string $state): string => Ticket::statusColors()[$state] ?? 'gray'),
                                TextEntry::make('priority')
                                    ->label('Priority')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => static::formatPriority($state))
                                    ->color(fn (string $state): string => Ticket::priorityColors()[$state] ?? 'gray'),
                                TextEntry::make('resolved_at')
                                    ->label('Resolved At')
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                        Section::make('Ownership')
                            ->schema([
                                TextEntry::make('customer.name')
                                    ->label('Customer')
                                    ->placeholder('-'),
                                TextEntry::make('assignedTo.name')
                                    ->label('Assigned To')
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
            ViewTicket::class,
            EditTicket::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'view'   => ViewTicket::route('/{record}'),
            'edit'   => EditTicket::route('/{record}/edit'),
        ];
    }

    protected static function formatStatus(string $status): string
    {
        return Ticket::statusOptions()[$status] ?? str($status)->headline()->toString();
    }

    protected static function formatPriority(string $priority): string
    {
        return Ticket::priorityOptions()[$priority] ?? str($priority)->headline()->toString();
    }
}
```

## plugins/webkul/customer-support/src/Filament/Admin/Resources/TicketResource/Pages/ListTickets.php

`$language
<?php

namespace Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource;
use Webkul\TableViews\Filament\Components\PresetView;
use Webkul\TableViews\Filament\Concerns\HasTableViews;

class ListTickets extends ListRecords
{
    use HasTableViews;

    protected static string $resource = TicketResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'my_tickets' => PresetView::make('My Tickets')
                ->icon('heroicon-s-user')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('assigned_to', Auth::id());
                }),

            'open' => PresetView::make('Open')
                ->icon('heroicon-s-inbox')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('status', 'open');
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Ticket')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
```

## plugins/webkul/customer-support/src/Filament/Admin/Resources/TicketResource/Pages/CreateTicket.php

`$language
<?php

namespace Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Ticket created')
            ->body('The ticket has been created successfully.');
    }
}
```

## plugins/webkul/customer-support/src/Filament/Admin/Resources/TicketResource/Pages/EditTicket.php

`$language
<?php

namespace Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Ticket saved')
            ->body('The ticket has been updated successfully.');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Ticket deleted')
                        ->body('The ticket has been deleted successfully.'),
                ),
        ];
    }
}
```

## plugins/webkul/customer-support/src/Filament/Admin/Resources/TicketResource/Pages/ViewTicket.php

`$language
<?php

namespace Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Ticket deleted')
                        ->body('The ticket has been deleted successfully.'),
                ),
        ];
    }
}
```

