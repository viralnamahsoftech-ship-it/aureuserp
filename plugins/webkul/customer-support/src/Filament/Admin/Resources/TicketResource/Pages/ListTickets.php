<?php

namespace Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Webkul\CustomerSupport\Filament\Admin\Resources\TicketResource;
use Webkul\TableViews\Filament\Components\PresetView;
use Webkul\TableViews\Filament\Concerns\HasTableViews;

class ListTickets extends ListRecords
{
    use HasTableViews;

    protected static string $resource = TicketResource::class;

    public function getPresetTableViews(): array
    {
        return [
            'my_tickets' => PresetView::make('My Tickets')
                ->icon('heroicon-s-user')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('assigned_to', Auth::id());
                }),

            'open' => PresetView::make('Open')
                ->icon('heroicon-s-inbox')
                ->favorite()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('status', 'open');
                }),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Ticket')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
