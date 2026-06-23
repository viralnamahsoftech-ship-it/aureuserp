<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewIndustryType extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = IndustryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
