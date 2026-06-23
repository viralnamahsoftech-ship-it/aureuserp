<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyMasterResource;

class ListPartyMasters extends ListRecords
{
    protected static string $resource = PartyMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
