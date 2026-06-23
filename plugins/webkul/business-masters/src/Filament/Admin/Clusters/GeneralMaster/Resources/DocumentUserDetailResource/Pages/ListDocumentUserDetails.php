<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Webkul\BusinessMasters\Filament\Admin\Clusters\GeneralMaster\Resources\DocumentUserDetailResource;

class ListDocumentUserDetails extends ListRecords
{
    protected static string $resource = DocumentUserDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle'),
        ];
    }
}
