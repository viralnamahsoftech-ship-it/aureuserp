<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\BranchMasterResource;

class ListBranchMasters extends ListRecords
{
    protected static string $resource = BranchMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
