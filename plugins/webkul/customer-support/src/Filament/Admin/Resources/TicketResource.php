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
