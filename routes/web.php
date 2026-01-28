<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\ArchiveController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('Invoices.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('invoices', InvoicesController::class)->middleware(['auth', 'verified']);

Route::resource('section', SectionController::class)->middleware(['auth', 'verified']);

Route::resource('products', ProductsController::class)->middleware(['auth', 'verified']);

Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class)->middleware(['auth', 'verified']);

Route::resource('Archive', ArchiveController::class)->middleware(['auth', 'verified']);

Route::get('edit_invoices/{id}', [InvoicesController::class, 'edit'])->middleware(['auth', 'verified']);

Route::get('invoices_details/{id}', [InvoicesDetailsController::class, 'index'])->middleware(['auth', 'verified'])->name('invoices_details');

Route::get('sections/{id}', [InvoicesController::class, 'getproducts'])->middleware(['auth', 'verified']);

Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'download'])->name('download_file');

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file'])->name('view_file');

Route::get('change_Status/{id}', [InvoicesController::class, 'show'])->name('change_Status');

Route::post('status_update/{id}', [InvoicesController::class, 'status_update'])->name('status_update');

Route::get('print_invoice/{id}', [InvoicesController::class, 'print_invoice'])->name('print_invoice');

Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::get('Paid_invoices', [InvoicesController::class, 'Paid_invoices']);

Route::get('unPaid_invoices', [InvoicesController::class, 'unPaid_invoices']);

Route::get('Partially_invoices', [InvoicesController::class, 'Partially_invoices']);

require __DIR__.'/auth.php';

Route::get('/{page}', [AdminController::class, 'index'])->middleware(['auth', 'verified']);

