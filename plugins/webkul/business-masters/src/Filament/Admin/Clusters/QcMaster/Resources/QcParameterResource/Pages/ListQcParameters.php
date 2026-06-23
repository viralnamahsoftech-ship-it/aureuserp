<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\QcMaster\Resources\QcParameterResource;

class ListQcParameters extends ListRecords
{
    protected static string $resource = QcParameterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
