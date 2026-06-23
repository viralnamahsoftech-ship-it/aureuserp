<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CountryResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\CountryResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewCountry extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
