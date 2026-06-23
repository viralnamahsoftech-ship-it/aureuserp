<?php

namespace Webkul\BusinessParty;

use Filament\Panel;
use Webkul\PluginManager\Console\Commands\InstallCommand;
use Webkul\PluginManager\Console\Commands\UninstallCommand;
use Webkul\PluginManager\Package;
use Webkul\PluginManager\PackageServiceProvider;

class BusinessPartyServiceProvider extends PackageServiceProvider
{
    public static string $name = 'business-party';

    public static string $viewNamespace = 'business-party';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                0  => '2026_01_01_000001_create_bp_industry_types_table',
                1  => '2026_01_01_000002_create_bp_party_types_table',
                2  => '2026_01_01_000003_create_bp_party_groups_table',
                3  => '2026_01_01_000004_create_bp_party_masters_table',
                4  => '2026_01_01_000005_create_bp_party_addresses_table',
                5  => '2026_01_01_000006_create_bp_party_contact_persons_table',
                6  => '2026_01_01_000007_create_bp_party_bank_details_table',
                7  => '2026_01_01_000008_create_bp_branch_user_rights_table',
                8  => '2026_01_01_000009_create_bp_item_categories_table',
                9  => '2026_01_01_000010_create_bp_item_groups_table',
                10 => '2026_01_01_000011_create_bp_item_main_sub_groups_table',
                11 => '2026_01_01_000012_create_bp_uoms_table',
                12 => '2026_01_01_000013_create_bp_hsn_masters_table',
                13 => '2026_01_01_000014_create_bp_item_masters_table',
                14 => '2026_01_01_000015_create_bp_process_masters_table',
                15 => '2026_01_01_000016_create_bp_operator_masters_table',
                16 => '2026_01_01_000017_create_bp_bom_masters_table',
                17 => '2026_01_01_000018_create_bp_bom_lines_table',
            ])
            ->runsMigrations()
            ->hasSeeder('Webkul\BusinessParty\\Database\\Seeders\\DatabaseSeeder')
            ->hasDependencies([
                0 => 'business-masters',
            ])
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->installDependencies()
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command): void {})
            ->icon('heroicon-o-rectangle-stack');
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            $panel->plugin(BusinessPartyPlugin::make());
        });
    }
}
