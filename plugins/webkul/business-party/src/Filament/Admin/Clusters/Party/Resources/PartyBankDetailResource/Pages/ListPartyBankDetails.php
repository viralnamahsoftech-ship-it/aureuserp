<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource;

class ListPartyBankDetails extends ListRecords
{
    protected static string $resource = PartyBankDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
