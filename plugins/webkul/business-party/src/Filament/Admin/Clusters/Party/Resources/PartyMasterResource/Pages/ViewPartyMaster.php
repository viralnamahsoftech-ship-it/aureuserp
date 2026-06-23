<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewPartyMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PartyMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PartyMasterResource::getApproveAction(),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
