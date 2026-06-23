<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StateResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\StateResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewState extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = StateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
