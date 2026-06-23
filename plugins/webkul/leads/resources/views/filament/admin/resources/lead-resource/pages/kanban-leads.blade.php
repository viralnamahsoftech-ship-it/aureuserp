<x-filament-panels::page>
    <form method="GET" class="mb-4 grid gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900 md:grid-cols-[1fr_220px_220px_auto]">
        <input
            name="q"
            value="{{ request('q') }}"
            placeholder="Search lead, customer, phone, email"
            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800"
        />

        <select
            name="priority"
            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800"
        >
            <option value="">All priorities</option>
            @foreach ($this->getPriorityOptions() as $value => $label)
                <option value="{{ $value }}" @selected(request('priority') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <select
            name="assigned_to"
            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800"
        >
            <option value="">All owners</option>
            @foreach ($this->getOwnerOptions() as $value => $label)
                <option value="{{ $value }}" @selected((string) request('assigned_to') === (string) $value)>{{ $label }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="rounded-md bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                Search
            </button>
            <a href="{{ \Webkul\Lead\Filament\Admin\Resources\LeadResource::getUrl('kanban') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                Clear
            </a>
        </div>
    </form>

    <div class="flex gap-4 overflow-x-auto pb-2">
        @foreach ($this->getColumns() as $column)
            <section class="min-w-72 rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                <header class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-200 bg-gray-50 px-3 py-2 dark:border-gray-700 dark:bg-gray-900">
                    <div class="min-w-0">
                        <h3 class="truncate text-sm font-semibold text-gray-950 dark:text-white">
                            {{ $column['label'] }}
                        </h3>
                    </div>
                    <span class="rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-gray-700 ring-1 ring-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:ring-gray-700">
                        {{ $column['records']->count() }}
                    </span>
                </header>

                <div class="space-y-3 p-3">
                    @forelse ($column['records'] as $lead)
                        <article class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <a
                                        href="{{ \Webkul\Lead\Filament\Admin\Resources\LeadResource::getUrl('view', ['record' => $lead]) }}"
                                        class="truncate text-sm font-semibold text-primary-600 hover:underline"
                                    >
                                        {{ $lead->lead_number }}
                                    </a>
                                    <p class="mt-1 truncate text-sm font-semibold text-gray-950 dark:text-white">
                                        {{ $lead->business_name }}
                                    </p>
                                </div>

                                <a
                                    href="{{ \Webkul\Lead\Filament\Admin\Resources\LeadResource::getUrl('edit', ['record' => $lead]) }}"
                                    class="shrink-0 rounded-md border border-primary-200 px-2 py-1 text-xs font-semibold text-primary-700 hover:bg-primary-50 dark:border-primary-800 dark:text-primary-300 dark:hover:bg-primary-950"
                                >
                                    Edit
                                </a>
                            </div>

                            <div class="mt-3 space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                <p class="truncate">{{ $lead->contact_name }} @if ($lead->phone) | {{ $lead->phone }} @endif</p>
                                @if ($lead->email)
                                    <p class="truncate">{{ $lead->email }}</p>
                                @endif
                                <p class="truncate">{{ $lead->business_segment ?: 'No segment' }} @if ($lead->business_category) | {{ $lead->business_category }} @endif</p>
                                <p class="truncate">{{ $lead->full_address ?: ($lead->location ?: 'No location') }}</p>
                            </div>

                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                    {{ \Webkul\Lead\Models\Lead::priorityOptions()[$lead->priority] ?? str($lead->priority)->headline() }}
                                </span>

                                @if ($lead->pv_capacity)
                                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        PV {{ $lead->pv_capacity }} kWh
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 flex items-center justify-between gap-2 border-t border-gray-100 pt-3 text-xs text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                <span class="truncate">{{ $lead->assignedTo?->name ?: 'Unassigned' }}</span>
                                <span>{{ $lead->lead_date?->format('d/m/Y') ?: $lead->created_at?->format('d/m/Y') }}</span>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-gray-300 p-4 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                            No leads
                        </div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-filament-panels::page>
