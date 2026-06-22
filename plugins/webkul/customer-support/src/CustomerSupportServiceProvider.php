<?php

namespace Webkul\CustomerSupport;

use Filament\Panel;
use Webkul\PluginManager\Console\Commands\InstallCommand;
use Webkul\PluginManager\Console\Commands\UninstallCommand;
use Webkul\PluginManager\Package;
use Webkul\PluginManager\PackageServiceProvider;

class CustomerSupportServiceProvider extends PackageServiceProvider
{
    public static string $name = 'customer-support';

    public static string $viewNamespace = 'customer-support';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2026_01_01_000001_create_customer_support_tickets_table',
            ])
            ->runsMigrations()
            ->hasSettings([
            ])
            ->runsSettings()
            ->hasDependencies([
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->runsMigrations();
            })
            ->hasUninstallCommand(function (UninstallCommand $command) {})
            ->icon('heroicon-o-lifebuoy');
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            $panel->plugin(CustomerSupportPlugin::make());
        });
    }
}
