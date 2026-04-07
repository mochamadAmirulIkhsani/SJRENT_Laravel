<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Public Routes - Company Profile
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/fleet', [FleetController::class, 'index'])->name('fleet.index');
Route::get('/fleet/{slug}', [FleetController::class, 'show'])->name('fleet.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::middleware('auth')->group(function (): void {
    Route::get('/rentals/{rental}/invoice', [InvoiceController::class, 'show'])->name('rentals.invoice');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
});
