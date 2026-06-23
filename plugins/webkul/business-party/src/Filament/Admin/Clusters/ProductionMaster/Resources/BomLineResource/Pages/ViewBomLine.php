<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomLineResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\BomLineResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewBomLine extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = BomLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
