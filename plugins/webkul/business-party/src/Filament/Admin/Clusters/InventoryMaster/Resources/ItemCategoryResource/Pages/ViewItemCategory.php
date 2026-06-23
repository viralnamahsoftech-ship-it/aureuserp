<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\InventoryMaster\Resources\ItemCategoryResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewItemCategory extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = ItemCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
