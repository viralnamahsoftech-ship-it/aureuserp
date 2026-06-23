<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentTypeMasterResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentTypeMasterResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewDocumentTypeMaster extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = DocumentTypeMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
