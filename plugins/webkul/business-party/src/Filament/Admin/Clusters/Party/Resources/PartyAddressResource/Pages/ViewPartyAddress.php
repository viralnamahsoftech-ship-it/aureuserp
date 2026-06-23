<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewPartyAddress extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PartyAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
