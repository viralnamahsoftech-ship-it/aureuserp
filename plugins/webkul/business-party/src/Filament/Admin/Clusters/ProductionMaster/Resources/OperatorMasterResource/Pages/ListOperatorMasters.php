<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\ProductionMaster\Resources\OperatorMasterResource;

class ListOperatorMasters extends ListRecords
{
    protected static string $resource = OperatorMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
