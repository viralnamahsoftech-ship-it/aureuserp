<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateLineResource;

class ListTaxTemplateLines extends ListRecords
{
    protected static string $resource = TaxTemplateLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
