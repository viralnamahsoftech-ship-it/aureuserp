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
