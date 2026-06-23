<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource;

class CreateOperatorMaster extends CreateRecord
{
    protected static string $resource = OperatorMasterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()->success()->title('Created')->body('Record created successfully.');
    }
}
