<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CityResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CityResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewCity extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
