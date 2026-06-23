<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\PartyGroupResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewPartyGroup extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = PartyGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
