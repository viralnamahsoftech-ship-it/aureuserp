<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewBomMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = BomMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
