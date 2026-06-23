<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewPartyContactPerson extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PartyContactPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
