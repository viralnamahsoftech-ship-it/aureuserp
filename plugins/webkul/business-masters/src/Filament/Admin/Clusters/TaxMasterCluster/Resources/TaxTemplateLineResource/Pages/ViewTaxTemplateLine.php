<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewTaxTemplateLine extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = TaxTemplateLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
