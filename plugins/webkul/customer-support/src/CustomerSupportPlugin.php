<?php

namespace Webkul\CustomerSupport;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Webkul\PluginManager\Package;

class CustomerSupportPlugin implements Plugin
{
    public function getId(): string
    {
        return 'customer-support';
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
            ->when($panel->getId() == 'customer', function (Panel $panel) {
                $panel
                    ->discoverResources(
                        in: __DIR__.'/Filament/Customer/Resources',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Resources'
                    )
                    ->discoverPages(
                        in: __DIR__.'/Filament/Customer/Pages',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Pages'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Customer/Clusters',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Clusters'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Customer/Widgets',
                        for: 'Webkul\\CustomerSupport\\Filament\\Customer\\Widgets'
                    );
            })
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel
                    ->discoverResources(
                        in: __DIR__.'/Filament/Admin/Resources',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Resources'
                    )
                    ->discoverPages(
                        in: __DIR__.'/Filament/Admin/Pages',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Pages'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Admin/Clusters',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Clusters'
                    )
                    ->discoverClusters(
                        in: __DIR__.'/Filament/Admin/Widgets',
                        for: 'Webkul\\CustomerSupport\\Filament\\Admin\\Widgets'
                    );
            });
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
