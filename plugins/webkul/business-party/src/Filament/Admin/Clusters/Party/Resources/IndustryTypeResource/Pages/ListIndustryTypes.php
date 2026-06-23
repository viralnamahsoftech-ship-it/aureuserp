<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessParty\Filament\Admin\Clusters\Party\Resources\IndustryTypeResource;

class ListIndustryTypes extends ListRecords
{
    protected static string $resource = IndustryTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
