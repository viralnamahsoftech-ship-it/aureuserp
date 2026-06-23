<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource;

class ListBranchUserRights extends ListRecords
{
    protected static string $resource = BranchUserRightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
