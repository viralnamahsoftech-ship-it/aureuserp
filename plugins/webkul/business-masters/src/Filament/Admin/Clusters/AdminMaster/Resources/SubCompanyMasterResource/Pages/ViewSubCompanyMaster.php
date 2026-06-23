<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SubCompanyMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SubCompanyMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewSubCompanyMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = SubCompanyMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
