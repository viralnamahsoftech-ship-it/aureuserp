<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class ProductionMaster extends Cluster
{
    protected static ?string $slug = 'masters/production';

    protected static ?int $navigationSort = 7;

    public static function getNavigationLabel(): string
    {
        return 'Production';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
