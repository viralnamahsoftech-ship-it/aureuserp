<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource;

class CreateItemCategory extends CreateRecord
{
    protected static string $resource = ItemCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()->success()->title('Created')->body('Record created successfully.');
    }
}
