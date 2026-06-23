<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class InventoryMaster extends Cluster
{
    protected static ?string $slug = 'masters/inventory';

    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return 'Inventory';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
