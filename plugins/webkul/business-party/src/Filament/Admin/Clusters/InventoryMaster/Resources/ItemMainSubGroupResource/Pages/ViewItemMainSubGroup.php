<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMainSubGroupResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemMainSubGroupResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewItemMainSubGroup extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = ItemMainSubGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
