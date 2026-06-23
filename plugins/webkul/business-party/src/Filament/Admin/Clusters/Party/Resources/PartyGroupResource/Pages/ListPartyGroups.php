<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource;

class ListPartyGroups extends ListRecords
{
    protected static string $resource = PartyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
