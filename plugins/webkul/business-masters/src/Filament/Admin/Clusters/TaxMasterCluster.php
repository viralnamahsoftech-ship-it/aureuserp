<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class TaxMasterCluster extends Cluster
{
    protected static ?string $slug = 'masters/tax-master';

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return 'Tax Master';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
