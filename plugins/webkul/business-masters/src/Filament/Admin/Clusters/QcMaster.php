<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class QcMaster extends Cluster
{
    protected static ?string $slug = 'masters/qc-master';

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return 'QC Master';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
