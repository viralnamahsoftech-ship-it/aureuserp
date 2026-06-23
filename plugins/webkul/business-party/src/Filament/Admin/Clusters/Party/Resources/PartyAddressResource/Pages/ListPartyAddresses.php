<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyAddressResource;

class ListPartyAddresses extends ListRecords
{
    protected static string $resource = PartyAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
