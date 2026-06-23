<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewStageMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = StageMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
