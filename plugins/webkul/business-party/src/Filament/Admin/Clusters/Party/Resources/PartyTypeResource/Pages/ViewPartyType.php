<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewPartyType extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PartyTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
