<?php

namespace Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Webkul\Lead\Filament\Admin\Resources\LeadResource;

class EditLead extends EditRecord
{
    protected static string $resource = LeadResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Lead saved')
            ->body('The lead has been updated successfully.');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            LeadResource::changeStageAction(),
            LeadResource::logCallAction(),
            DeleteAction::make(),
        ];
    }
}
