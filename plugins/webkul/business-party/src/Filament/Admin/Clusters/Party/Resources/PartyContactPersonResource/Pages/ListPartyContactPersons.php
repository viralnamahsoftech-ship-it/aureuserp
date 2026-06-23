<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyContactPersonResource;

class ListPartyContactPersons extends ListRecords
{
    protected static string $resource = PartyContactPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
