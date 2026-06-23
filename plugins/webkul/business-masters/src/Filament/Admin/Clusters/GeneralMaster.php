<?php

namespace Webkul\BusinessMasters\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class GeneralMaster extends Cluster
{
    protected static ?string $slug = 'masters/general-master';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return 'General Master';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
