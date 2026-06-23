<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SerialNoMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\SerialNoMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewSerialNoMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = SerialNoMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
