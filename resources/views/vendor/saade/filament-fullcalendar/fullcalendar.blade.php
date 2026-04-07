@php
    $plugin = \Saade\FilamentFullCalendar\FilamentFullCalendarPlugin::get();
@endphp

<style>
    @media (max-width: 640px) {
        .mobile-friendly-calendar .fc-header-toolbar {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 0.5rem;
        }

        .mobile-friendly-calendar .fc-header-toolbar .fc-toolbar-chunk {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .mobile-friendly-calendar .fc-header-toolbar .fc-toolbar-chunk:first-child {
            order: 2;
            justify-content: space-between;
        }

        .mobile-friendly-calendar .fc-header-toolbar .fc-toolbar-chunk:nth-child(2) {
            order: 1;
        }

        .mobile-friendly-calendar .fc-header-toolbar .fc-toolbar-chunk:last-child {
            order: 3;
            justify-content: center;
        }

        .mobile-friendly-calendar .fc-toolbar-title {
            font-size: 1rem !important;
            line-height: 1.5rem;
            text-align: center;
        }

        .mobile-friendly-calendar.fc .fc-button {
            min-height: 2rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .mobile-friendly-calendar .fc-daygrid-day-frame {
            min-height: 3.5rem;
        }

        .mobile-friendly-calendar .fc-daygrid-day-number {
            padding: 0.25rem;
            font-size: 0.75rem;
        }

        .mobile-friendly-calendar .fc-daygrid-event {
            margin: 0.125rem;
            border-radius: 0.25rem;
            padding: 0 0.25rem;
            font-size: 0.625rem;
            line-height: 1rem;
        }
    }
</style>

<x-filament-widgets::widget class="calendar-mobile-widget">
    <x-filament::section>
        <div class="mb-4 flex flex-1 justify-start sm:justify-end">
            <x-filament-actions::actions :actions="$this->getCachedHeaderActions()" class="w-full sm:w-auto [&_.fi-ac]:w-full sm:[&_.fi-ac]:w-auto" />
        </div>

        <div class="filament-fullcalendar mobile-friendly-calendar" wire:ignore x-load
            x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-fullcalendar-alpine', 'saade/filament-fullcalendar') }}"
            ax-load-css="{{ \Filament\Support\Facades\FilamentAsset::getStyleHref('filament-fullcalendar-styles', 'saade/filament-fullcalendar') }}"
            x-ignore x-data="fullcalendar({
                locale: @js($plugin->getLocale()),
                plugins: @js($plugin->getPlugins()),
                schedulerLicenseKey: @js($plugin->getSchedulerLicenseKey()),
                timeZone: @js($plugin->getTimezone()),
                config: @js($this->getConfig()),
                editable: @json($plugin->isEditable()),
                selectable: @json($plugin->isSelectable()),
                eventClassNames: {!! htmlspecialchars($this->eventClassNames(), ENT_COMPAT) !!},
                eventContent: {!! htmlspecialchars($this->eventContent(), ENT_COMPAT) !!},
                eventDidMount: {!! htmlspecialchars($this->eventDidMount(), ENT_COMPAT) !!},
                eventWillUnmount: {!! htmlspecialchars($this->eventWillUnmount(), ENT_COMPAT) !!},
            })">
        </div>
    </x-filament::section>

    <x-filament-actions::modals />
</x-filament-widgets::widget>
