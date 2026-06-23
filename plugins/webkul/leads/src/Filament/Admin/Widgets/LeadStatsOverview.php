<?php

namespace Webkul\Lead\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Webkul\Lead\Models\Lead;

class LeadStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $openStages = array_diff(array_keys(Lead::stageOptions()), [
            Lead::STAGE_WON,
            Lead::STAGE_LOST,
            Lead::STAGE_DISQUALIFIED,
        ]);

        return [
            Stat::make('Total Leads', Lead::query()->count())
                ->description('All captured leads')
                ->icon('heroicon-o-funnel'),

            Stat::make('Open Pipeline', Lead::query()->whereIn('stage', $openStages)->count())
                ->description('Needs sales action')
                ->icon('heroicon-o-arrow-trending-up')
                ->color('info'),

            Stat::make('Won', Lead::query()->where('stage', Lead::STAGE_WON)->count())
                ->description('Converted leads')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Lost / Disqualified', Lead::query()->whereIn('stage', [Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED])->count())
                ->description('Closed without conversion')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Follow Up Due', Lead::query()->whereNotNull('next_follow_up_at')->where('next_follow_up_at', '<=', now())->count())
                ->description('Past or due now')
                ->icon('heroicon-o-calendar-days')
                ->color('warning'),
        ];
    }
}
