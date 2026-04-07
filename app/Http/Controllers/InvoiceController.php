<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Rental $rental)
    {
        $rental->load(['customer', 'motorcycle', 'payments', 'creator']);

        $pdf = Pdf::loadView('pdf.invoice', [
            'rental' => $rental,
        ])->setPaper('a4');

        return $pdf->stream("invoice-rental-{$rental->id}.pdf");
    }
}
