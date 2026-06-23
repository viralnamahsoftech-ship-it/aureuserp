<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewOperatorMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = OperatorMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
