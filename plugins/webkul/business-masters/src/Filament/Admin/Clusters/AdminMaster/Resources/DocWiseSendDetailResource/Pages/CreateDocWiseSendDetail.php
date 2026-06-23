<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource;

class CreateDocWiseSendDetail extends CreateRecord
{
    protected static string $resource = DocWiseSendDetailResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()->success()->title('Created')->body('Record created successfully.');
    }
}
