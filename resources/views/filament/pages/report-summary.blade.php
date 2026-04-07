<x-filament-panels::page>
	<form method="GET" class="grid gap-4 md:grid-cols-3">
		<div>
			<label for="start_date" class="text-sm font-medium">Tanggal Mulai</label>
			<input id="start_date" type="date" name="start_date" value="{{ $this->startDate }}" class="mt-1 w-full rounded-lg border-gray-300" />
		</div>
		<div>
			<label for="end_date" class="text-sm font-medium">Tanggal Akhir</label>
			<input id="end_date" type="date" name="end_date" value="{{ $this->endDate }}" class="mt-1 w-full rounded-lg border-gray-300" />
		</div>
		<div class="flex items-end">
			<button class="w-full rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-500" type="submit">Terapkan</button>
		</div>
	</form>

	<div class="grid gap-4 md:grid-cols-4">
		<div class="rounded-xl border bg-white p-4">
			<p class="text-xs text-gray-500">Transaksi</p>
			<p class="text-2xl font-bold">{{ $this->summary['transactions'] }}</p>
		</div>
		<div class="rounded-xl border bg-white p-4">
			<p class="text-xs text-gray-500">Pendapatan Kotor</p>
			<p class="text-2xl font-bold">Rp {{ number_format($this->summary['gross'], 0, ',', '.') }}</p>
		</div>
		<div class="rounded-xl border bg-white p-4">
			<p class="text-xs text-gray-500">Denda</p>
			<p class="text-2xl font-bold">Rp {{ number_format($this->summary['late'], 0, ',', '.') }}</p>
		</div>
		<div class="rounded-xl border bg-white p-4">
			<p class="text-xs text-gray-500">Pendapatan Bersih</p>
			<p class="text-2xl font-bold">Rp {{ number_format($this->summary['net'], 0, ',', '.') }}</p>
		</div>
	</div>

	<div class="rounded-xl border bg-white p-4">
		<div class="mb-3 flex items-center justify-between">
			<h3 class="font-semibold">Motor Paling Sering Disewa</h3>
			<div class="flex gap-2 text-xs">
				<a class="rounded bg-gray-100 px-3 py-1 hover:bg-gray-200" href="{{ route('reports.export.pdf', ['start_date' => $this->startDate, 'end_date' => $this->endDate]) }}" target="_blank">Export PDF</a>
				<a class="rounded bg-gray-100 px-3 py-1 hover:bg-gray-200" href="{{ route('reports.export.excel', ['start_date' => $this->startDate, 'end_date' => $this->endDate]) }}">Export Excel</a>
			</div>
		</div>
		<div class="space-y-2 text-sm">
			@forelse ($this->topMotorcycles as $row)
				<div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2">
					<span>{{ $row->motorcycle?->name ?? '-' }}</span>
					<span class="font-semibold">{{ $row->total }}x</span>
				</div>
			@empty
				<p class="text-gray-500">Belum ada data pada periode ini.</p>
			@endforelse
		</div>
	</div>
</x-filament-panels::page>
