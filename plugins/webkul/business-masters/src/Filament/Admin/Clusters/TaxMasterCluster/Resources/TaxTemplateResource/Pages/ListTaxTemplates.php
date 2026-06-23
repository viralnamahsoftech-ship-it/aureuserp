<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxTemplateResource;

class ListTaxTemplates extends ListRecords
{
    protected static string $resource = TaxTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
