<?php

namespace Webkul\BusinessParty\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class Party extends Cluster
{
    protected static ?string $slug = 'masters/party';

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return 'Party';
    }

    public static function getNavigationGroup(): string
    {
        return 'Masters';
    }
}
