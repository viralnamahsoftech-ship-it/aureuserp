<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyTypeResource;

class ListPartyTypes extends ListRecords
{
    protected static string $resource = PartyTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
