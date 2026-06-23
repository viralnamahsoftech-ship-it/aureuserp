<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class AdminMaster extends Cluster
{
    protected static ?string $slug = 'masters/admin-master';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Admin Master';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
