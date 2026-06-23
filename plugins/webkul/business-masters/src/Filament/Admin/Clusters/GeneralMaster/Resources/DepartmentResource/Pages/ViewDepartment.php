<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DepartmentResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DepartmentResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewDepartment extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = DepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
