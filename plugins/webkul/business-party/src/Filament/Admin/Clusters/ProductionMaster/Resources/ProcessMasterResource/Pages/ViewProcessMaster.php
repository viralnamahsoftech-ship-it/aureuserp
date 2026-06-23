<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\ProcessMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewProcessMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = ProcessMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
