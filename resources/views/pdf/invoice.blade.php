<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Rental #{{ $rental->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f8f8f8; text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Invoice Rental #{{ $rental->id }}</h2>
    <p>Pelanggan: {{ $rental->customer->name }}</p>
    <p>Motor: {{ $rental->motorcycle->name }} ({{ $rental->motorcycle->plate_number }})</p>
    <p>Tanggal Sewa: {{ $rental->start_date?->format('d M Y') }} - {{ $rental->estimated_return_date?->format('d M Y') }}</p>

    <table>
        <tr>
            <th>Item</th>
            <th class="text-right">Nominal</th>
        </tr>
        <tr>
            <td>Total Sewa</td>
            <td class="text-right">Rp {{ number_format((float) $rental->total_rent_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Denda</td>
            <td class="text-right">Rp {{ number_format((float) $rental->late_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Biaya Tambahan</td>
            <td class="text-right">Rp {{ number_format((float) $rental->additional_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <th class="text-right">Rp {{ number_format((float) $rental->grand_total, 0, ',', '.') }}</th>
        </tr>
    </table>

    <h4>Pembayaran</h4>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th class="text-right">Nominal</th>
        </tr>
        @forelse ($rental->payments as $payment)
            <tr>
                <td>{{ $payment->payment_date?->format('d M Y H:i') }}</td>
                <td>{{ $payment->payment_type }}</td>
                <td class="text-right">Rp {{ number_format((float) $payment->amount, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Belum ada pembayaran</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
