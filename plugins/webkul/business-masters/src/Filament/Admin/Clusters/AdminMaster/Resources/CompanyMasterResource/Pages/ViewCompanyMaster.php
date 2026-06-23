<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\CompanyMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\CompanyMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewCompanyMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = CompanyMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
