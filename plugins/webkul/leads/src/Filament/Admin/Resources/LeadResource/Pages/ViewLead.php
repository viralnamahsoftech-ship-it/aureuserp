<?php

namespace Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\Lead\Filament\Admin\Resources\LeadResource;

class ViewLead extends ViewRecord
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            LeadResource::changeStageAction(),
            LeadResource::logCallAction(),
            DeleteAction::make(),
        ];
    }
}
