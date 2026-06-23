<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\BranchUserRightResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewBranchUserRight extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = BranchUserRightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
