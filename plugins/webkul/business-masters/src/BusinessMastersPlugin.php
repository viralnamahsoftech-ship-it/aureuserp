<?php

namespace Webkul\BusinessMasters;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Webkul\PluginManager\Package;

class BusinessMastersPlugin implements Plugin
{
    public function getId(): string
    {
        return 'business-masters';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        if (! Package::isPluginInstalled($this->getId())) {
            return;
        }

        $panel
            ->when($panel->getId() === 'admin', function (Panel $panel): void {
                $panel
                    ->discoverResources(
                        in: __DIR__.'/Filament/Admin/Resources',
                        for: 'Webkul\BusinessMasters\\Filament\\Admin\\Resources',
                    )
                    ->discoverPages(
                        in: __DIR__.'/Filament/Admin/Pages',
                        for: 'Webkul\BusinessMasters\\Filament\\Admin\\Pages',
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Admin/Clusters',
                        for: 'Webkul\BusinessMasters\\Filament\\Admin\\Clusters',
                    )
                    ->discoverWidgets(
                        in: __DIR__.'/Filament/Admin/Widgets',
                        for: 'Webkul\BusinessMasters\\Filament\\Admin\\Widgets',
                    );
            });
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
