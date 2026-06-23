<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\UomResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\UomResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewUom extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
