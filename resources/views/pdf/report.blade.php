<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rental</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Rental</h2>
    <p>Periode: {{ $startDate }} s.d. {{ $endDate }}</p>
    <p>Total transaksi: {{ $summary['transactions'] }} | Pendapatan kotor: Rp {{ number_format($summary['gross_income'], 0, ',', '.') }} | Denda: Rp {{ number_format($summary['late_fee_income'], 0, ',', '.') }} | Pendapatan bersih: Rp {{ number_format($summary['net_income'], 0, ',', '.') }}</p>

    <table>
        <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Motor</th>
            <th>Mulai</th>
            <th>Estimasi Kembali</th>
            <th>Status</th>
            <th class="text-right">Grand Total</th>
        </tr>
        @foreach ($rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>
                <td>{{ $rental->customer->name }}</td>
                <td>{{ $rental->motorcycle->name }}</td>
                <td>{{ $rental->start_date?->toDateString() }}</td>
                <td>{{ $rental->estimated_return_date?->toDateString() }}</td>
                <td>{{ $rental->status }}</td>
                <td class="text-right">Rp {{ number_format((float) $rental->grand_total, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
