<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\DocWiseSendDetailResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewDocWiseSendDetail extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = DocWiseSendDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
