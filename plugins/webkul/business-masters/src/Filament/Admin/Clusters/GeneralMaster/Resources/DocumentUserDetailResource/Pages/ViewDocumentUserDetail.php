<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewDocumentUserDetail extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = DocumentUserDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
