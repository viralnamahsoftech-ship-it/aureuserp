<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\HsnMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\HsnMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewHsnMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = HsnMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
