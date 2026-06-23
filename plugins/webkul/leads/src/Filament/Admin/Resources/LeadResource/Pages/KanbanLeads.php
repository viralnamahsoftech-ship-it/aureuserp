<?php

namespace Webkul\Lead\Filament\Admin\Resources\LeadResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;
use Webkul\Lead\Filament\Admin\Resources\LeadResource;
use Webkul\Lead\Models\Lead;
use Webkul\Security\Models\User;

class KanbanLeads extends Page
{
    protected static string $resource = LeadResource::class;

    protected string $view = 'leads::filament.admin.resources.lead-resource.pages.kanban-leads';

    public function getTitle(): string
    {
        return 'Leads Kanban';
    }

    public function getHeading(): string
    {
        return 'Leads Kanban';
    }

    public function getColumns(): Collection
    {
        $leads = Lead::query()
            ->with(['assignedTo', 'creator'])
            ->when(request('q'), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('lead_number', 'like', "%{$search}%")
                        ->orWhere('business_name', 'like', "%{$search}%")
                        ->orWhere('contact_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(request('priority'), fn ($query, string $priority) => $query->where('priority', $priority))
            ->when(request('assigned_to'), fn ($query, string $userId) => $query->where('assigned_to', $userId))
            ->latest('lead_date')
            ->latest('created_at')
            ->get()
            ->groupBy('stage');

        return collect(LeadResource::timelineStages())
            ->map(fn (string $label, string $stage): array => [
                'stage'   => $stage,
                'label'   => $label,
                'color'   => Lead::stageColors()[$stage] ?? 'gray',
                'records' => $leads->get($stage, collect()),
            ]);
    }

    public function getPriorityOptions(): array
    {
        return Lead::priorityOptions();
    }

    public function getOwnerOptions(): array
    {
        return User::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('normal')
                ->label('Normal')
                ->icon('heroicon-o-list-bullet')
                ->url(fn (): string => LeadResource::getUrl('index')),
            Action::make('table')
                ->label('Table')
                ->icon('heroicon-o-table-cells')
                ->url(fn (): string => LeadResource::getUrl('index').'?view=table'),
            Action::make('new_lead')
                ->label('New Lead')
                ->icon('heroicon-o-plus-circle')
                ->url(fn (): string => LeadResource::getUrl('create')),
        ];
    }
}
