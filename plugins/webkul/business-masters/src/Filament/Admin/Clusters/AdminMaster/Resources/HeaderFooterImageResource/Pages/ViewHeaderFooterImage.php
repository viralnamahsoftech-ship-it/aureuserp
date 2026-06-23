<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\HeaderFooterImageResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Webkul\BusinessMasters\Filament\Admin\Clusters\AdminMaster\Resources\HeaderFooterImageResource;
use Webkul\Support\Traits\HasRecordNavigationTabs;

class ViewHeaderFooterImage extends ViewRecord
{
    use HasRecordNavigationTabs;

    protected static string $resource = HeaderFooterImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
