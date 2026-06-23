<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcTemplateLineResource;

class ListQcTemplateLines extends ListRecords
{
    protected static string $resource = QcTemplateLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
