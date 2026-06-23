<?php

namespace Webkul\BusinessMasters;

use Filament\Panel;
use Webkul\PluginManager\Console\Commands\InstallCommand;
use Webkul\PluginManager\Console\Commands\UninstallCommand;
use Webkul\PluginManager\Package;
use Webkul\PluginManager\PackageServiceProvider;

class BusinessMastersServiceProvider extends PackageServiceProvider
{
    public static string $name = 'business-masters';

    public static string $viewNamespace = 'business-masters';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasMigrations([
                0  => '2026_01_01_000001_create_bm_company_masters_table',
                1  => '2026_01_01_000002_create_bm_sub_company_masters_table',
                2  => '2026_01_01_000003_create_bm_branch_masters_table',
                3  => '2026_01_01_000004_create_bm_serial_no_masters_table',
                4  => '2026_01_01_000005_create_bm_doc_wise_serial_nos_table',
                5  => '2026_01_01_000006_create_bm_header_footer_images_table',
                6  => '2026_01_01_000007_create_bm_doc_wise_send_details_table',
                7  => '2026_01_01_000008_create_bm_countries_table',
                8  => '2026_01_01_000009_create_bm_states_table',
                9  => '2026_01_01_000010_create_bm_cities_table',
                10 => '2026_01_01_000011_create_bm_departments_table',
                11 => '2026_01_01_000012_create_bm_designations_table',
                12 => '2026_01_01_000013_create_bm_currencies_table',
                13 => '2026_01_01_000014_create_bm_reference_masters_table',
                14 => '2026_01_01_000015_create_bm_stage_masters_table',
                15 => '2026_01_01_000016_create_bm_document_type_masters_table',
                16 => '2026_01_01_000017_create_bm_document_user_details_table',
                17 => '2026_01_01_000018_create_bm_task_types_table',
                18 => '2026_01_01_000019_create_bm_tax_masters_table',
                19 => '2026_01_01_000020_create_bm_tax_templates_table',
                20 => '2026_01_01_000021_create_bm_tax_template_lines_table',
                21 => '2026_01_01_000022_create_bm_qc_parameters_table',
                22 => '2026_01_01_000023_create_bm_qc_templates_table',
                23 => '2026_01_01_000024_create_bm_qc_template_lines_table',
            ])
            ->runsMigrations()
            ->hasSeeder('Webkul\BusinessMasters\\Database\\Seeders\\DatabaseSeeder')
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command
                    ->runsMigrations()
                    ->runsSeeders();
            })
            ->hasUninstallCommand(function (UninstallCommand $command): void {})
            ->icon('heroicon-o-rectangle-stack');
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            $panel->plugin(BusinessMastersPlugin::make());
        });
    }
}
