<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\ReferenceMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\ReferenceMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class EditReferenceMaster extends EditRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = ReferenceMasterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()->success()->title('Saved')->body('Record saved successfully.');
    }
}
