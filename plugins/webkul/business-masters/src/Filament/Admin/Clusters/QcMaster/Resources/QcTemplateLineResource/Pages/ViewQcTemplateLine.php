<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewQcTemplateLine extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = QcTemplateLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
