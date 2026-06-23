<?php

namespace Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Webkul\Lead\Filament\Admin\Resources\LeadResource;
use Webkul\Lead\Filament\Admin\Widgets\LeadStatsOverview;
use Webkul\Lead\Models\Lead;
use Webkul\TableViews\Filament\Components\PresetView;
use Webkul\TableViews\Filament\Concerns\HasTableViews;

class ListLeads extends ListRecords
{
    use HasTableViews;

    protected static string $resource = LeadResource::class;

    public function getHeaderWidgets(): array
    {
        return [
            LeadStatsOverview::make(),
        ];
    }

    public function getPresetTableViews(): array
    {
        return [
            'all_leads' => PresetView::make('All Leads')
                ->icon('heroicon-s-list-bullet')
                ->setAsDefault(),

            'my_leads' => PresetView::make('My Leads')
                ->icon('heroicon-s-user')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('assigned_to', Auth::id());
                }),

            'follow_up_due' => PresetView::make('Follow Up Due')
                ->icon('heroicon-s-calendar-days')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query
                        ->whereNotNull('next_follow_up_at')
                        ->where('next_follow_up_at', '<=', now());
                }),

            'open_pipeline' => PresetView::make('Open Pipeline')
                ->icon('heroicon-s-funnel')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereNotIn('stage', [Lead::STAGE_WON, Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED]);
                }),

            'kanban_new' => PresetView::make('New')
                ->icon('heroicon-s-sparkles')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('stage', Lead::STAGE_NEW)),

            'kanban_quotation' => PresetView::make('Quotation')
                ->icon('heroicon-s-document-text')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('stage', Lead::STAGE_QUOTATION)),

            'kanban_meeting_done' => PresetView::make('Meeting Done')
                ->icon('heroicon-s-hand-raised')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('stage', Lead::STAGE_MEETING_DONE)),

            'won' => PresetView::make('Won')
                ->icon('heroicon-s-check-circle')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('stage', Lead::STAGE_WON)),

            'lost' => PresetView::make('Lost / Disqualified')
                ->icon('heroicon-s-x-circle')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereIn('stage', [Lead::STAGE_LOST, Lead::STAGE_DISQUALIFIED])),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            LeadResource::viewModeActions(),
            LeadResource::dataActions(),
            LeadResource::reportActions(),
            CreateAction::make()
                ->label('New Lead')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
