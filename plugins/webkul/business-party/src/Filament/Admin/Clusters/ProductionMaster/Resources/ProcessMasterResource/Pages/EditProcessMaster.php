<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class EditProcessMaster extends EditRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = ProcessMasterResource::class;

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
