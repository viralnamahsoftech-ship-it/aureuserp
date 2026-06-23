<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewBranchMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = BranchMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
