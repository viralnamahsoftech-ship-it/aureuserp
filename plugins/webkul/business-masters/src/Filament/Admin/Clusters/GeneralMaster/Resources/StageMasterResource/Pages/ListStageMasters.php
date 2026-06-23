<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StageMasterResource;

class ListStageMasters extends ListRecords
{
    protected static string $resource = StageMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
