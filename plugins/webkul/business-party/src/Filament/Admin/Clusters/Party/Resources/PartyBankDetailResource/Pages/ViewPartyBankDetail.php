<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyBankDetailResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewPartyBankDetail extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PartyBankDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
