<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewQcParameter extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = QcParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
