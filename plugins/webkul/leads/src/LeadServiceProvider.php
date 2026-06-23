<?php

namespace Webkul\Lead;

use Filament\Panel;
use Webkul\PluginManager\Console\Commands\InstallCommand;
use Webkul\PluginManager\Console\Commands\UninstallCommand;
use Webkul\PluginManager\Package;
use Webkul\PluginManager\PackageServiceProvider;

class LeadServiceProvider extends PackageServiceProvider
{
    public static string $name = 'leads';

    public static string $viewNamespace = 'leads';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations([
                '2026_01_01_000001_create_leads_leads_table',
                '2026_01_01_000002_create_leads_activities_table',
                '2026_01_01_000003_add_octabees_workflow_fields_to_leads_leads_table',
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
            ->icon('heroicon-o-funnel');
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            $panel->plugin(LeadPlugin::make());
        });
    }
}
