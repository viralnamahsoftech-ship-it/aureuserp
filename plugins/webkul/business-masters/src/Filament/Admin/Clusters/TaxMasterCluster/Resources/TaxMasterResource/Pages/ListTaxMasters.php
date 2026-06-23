<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxMasterResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\TaxMasterCluster\Resources\TaxMasterResource;

class ListTaxMasters extends ListRecords
{
    protected static string $resource = TaxMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
