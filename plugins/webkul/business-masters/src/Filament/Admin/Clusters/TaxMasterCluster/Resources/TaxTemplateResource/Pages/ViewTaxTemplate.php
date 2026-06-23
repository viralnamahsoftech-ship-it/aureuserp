<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewTaxTemplate extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = TaxTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
