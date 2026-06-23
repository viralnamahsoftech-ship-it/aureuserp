<?php

namespace Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Webkul\Lead\Filament\Admin\Resources\LeadResource;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Lead created')
            ->body('The lead has been created successfully.');
    }
}
