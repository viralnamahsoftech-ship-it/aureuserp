<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSerialNoResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSerialNoResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewDocWiseSerialNo extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = DocWiseSerialNoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
