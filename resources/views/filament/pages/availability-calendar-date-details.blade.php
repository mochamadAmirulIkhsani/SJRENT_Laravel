<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-xl border bg-gray-50 p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500">Tersedia</p>
            <p class="mt-2 text-2xl font-bold">{{ $dateDetails['availableMotorcycles']->count() }}</p>
        </div>
        <div class="rounded-xl border bg-gray-50 p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500">Dirental</p>
            <p class="mt-2 text-2xl font-bold">{{ $dateDetails['rentedMotorcycles']->count() }}</p>
        </div>
        <div class="rounded-xl border bg-gray-50 p-4">
            <p class="text-xs uppercase tracking-wide text-gray-500">Maintenance</p>
            <p class="mt-2 text-2xl font-bold">{{ $dateDetails['maintenanceMotorcycles']->count() }}</p>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-2">
        <div class="rounded-2xl border bg-white p-4">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="font-semibold">Motor Tersedia</h3>
                <span class="text-xs text-gray-500">{{ $dateDetails['availableMotorcycles']->count() }} unit</span>
            </div>
            <div class="space-y-2">
                @forelse ($dateDetails['availableMotorcycles'] as $motorcycle)
                    <div class="flex items-center justify-between gap-3 rounded-xl border px-3 py-2">
                        <div>
                            <p class="font-medium">{{ $motorcycle->name }}</p>
                            <p class="text-xs text-gray-500">{{ $motorcycle->plate_number }} · {{ $motorcycle->category?->name }}</p>
                        </div>
                        <x-cta-button href="{{ route('filament.admin.resources.rentals.create', ['start_date' => $dateDetails['date']->toDateString(), 'estimated_return_date' => $dateDetails['date']->toDateString(), 'motorcycle_id' => $motorcycle->id]) }}" variant="warning" size="sm">Sewa</x-cta-button>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada motor yang tersedia pada tanggal ini.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border bg-white p-4">
                <h3 class="mb-3 font-semibold">Motor Sedang Dirental</h3>
                <div class="space-y-2">
                    @forelse ($dateDetails['rentedMotorcycles'] as $motorcycle)
                        <div class="rounded-xl border px-3 py-2">
                            <p class="font-medium">{{ $motorcycle->name }}</p>
                            <p class="text-xs text-gray-500">{{ $motorcycle->plate_number }} · {{ $motorcycle->customer?->name ?? 'Aktif' }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada rental aktif.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border bg-white p-4">
                <h3 class="mb-3 font-semibold">Maintenance</h3>
                <div class="space-y-2">
                    @forelse ($dateDetails['maintenanceOverrides'] as $override)
                        <div class="rounded-xl border px-3 py-2">
                            <p class="font-medium">{{ $override->motorcycle?->name }}</p>
                            <p class="text-xs text-gray-500">{{ $override->reason ?? 'Maintenance terjadwal' }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada maintenance terjadwal.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
