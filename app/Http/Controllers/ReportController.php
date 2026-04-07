<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function exportPdf()
    {
        [$startDate, $endDate] = $this->validatedRange();

        $rentals = Rental::query()
            ->with(['customer', 'motorcycle'])
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date')
            ->get();

        $summary = $this->summary($rentals);

        $pdf = Pdf::loadView('pdf.report', [
            'rentals' => $rentals,
            'summary' => $summary,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->setPaper('a4', 'landscape');

        return $pdf->download("laporan-rental-{$startDate}-{$endDate}.pdf");
    }

    public function exportExcel(): BinaryFileResponse
    {
        [$startDate, $endDate] = $this->validatedRange();

        $rentals = Rental::query()
            ->with(['customer', 'motorcycle'])
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date')
            ->get();

        $tempPath = storage_path('app/report-rental.xlsx');
        $writer = new Writer();
        $writer->openToFile($tempPath);

        $writer->addRow(Row::fromValues([
            'ID',
            'Pelanggan',
            'Motor',
            'Tanggal Mulai',
            'Estimasi Kembali',
            'Tanggal Kembali',
            'Status',
            'Total',
            'Denda',
            'Biaya Tambahan',
            'Grand Total',
        ]));

        foreach ($rentals as $rental) {
            $writer->addRow(Row::fromValues([
                $rental->id,
                $rental->customer->name,
                $rental->motorcycle->name,
                $rental->start_date?->toDateString(),
                $rental->estimated_return_date?->toDateString(),
                $rental->actual_return_date?->toDateString(),
                $rental->status,
                (float) $rental->total_rent_price,
                (float) $rental->late_fee,
                (float) $rental->additional_fee,
                (float) $rental->grand_total,
            ]));
        }

        $writer->close();

        return response()->download($tempPath, "laporan-rental-{$startDate}-{$endDate}.xlsx")->deleteFileAfterSend(true);
    }

    private function validatedRange(): array
    {
        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->endOfMonth()->toDateString());

        if ($startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        return [$startDate, $endDate];
    }

    private function summary($rentals): array
    {
        $gross = (float) $rentals->sum('total_rent_price');
        $lateFee = (float) $rentals->sum('late_fee');
        $additional = (float) $rentals->sum('additional_fee');

        return [
            'transactions' => $rentals->count(),
            'gross_income' => $gross,
            'late_fee_income' => $lateFee,
            'net_income' => $gross + $lateFee + $additional,
        ];
    }
}
