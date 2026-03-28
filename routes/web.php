<?php

use App\Http\Controllers\ProfileController;
use App\Models\invoices;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('dashboard', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {

    Route::resource('invoices', InvoicesController::class)
    ->middleware(['permission:قائمة الفواتير']);
    
    Route::resource('section', SectionController::class)
    ->middleware(['permission:الاقسام']);
    
    Route::resource('products', ProductsController::class)
    ->middleware(['permission:عرض المنتجات|اضافة منتج|تعديل منتج|حذف منتج']);
    
    Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class)
    ->middleware(['permission:اضافة مرفق|حذف مرفق']);
    
    Route::resource('Archive', ArchiveController::class)
    ->middleware(['permission:ارشيف الفواتير']);
    
    Route::get('edit_invoices/{id}', [InvoicesController::class, 'edit']);
    
    Route::get('invoices_details/{id}', [InvoicesDetailsController::class, 'index'])->name('invoices_details');
    
    Route::get('sections/{id}', [InvoicesController::class, 'getproducts']);
    
    Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'download'])->name('download_file');
    
    Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file'])->name('view_file');
    
    Route::get('change_Status/{id}', [InvoicesController::class, 'show'])->name('change_Status');
    
    Route::post('status_update/{id}', [InvoicesController::class, 'status_update'])->name('status_update');
    
    Route::get('print_invoice/{id}', [InvoicesController::class, 'print_invoice'])->name('print_invoice');
    
    Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');
    
    Route::get('Paid_invoices', [InvoicesController::class, 'Paid_invoices'])
    ->middleware(['permission:الفواتير المدفوعة']);
    
    Route::get('unPaid_invoices', [InvoicesController::class, 'unPaid_invoices']);
    
    Route::get('Partially_invoices', [InvoicesController::class, 'Partially_invoices']);
    
    Route::get('export_invoices', [InvoicesController::class, 'export'])->name('export_invoices');
    
    Route::resource('roles', RoleController::class);
    
    Route::resource('users', UserController::class)->middleware('checkPermission');
    
    Route::get('reports_invoices', [ReportsController::class, 'index'])->name('reports_invoices');
    
    Route::get('reports_customers', [ReportsController::class, 'customers'])->name('reports_customers');
    
    Route::post('Search_invoices', [ReportsController::class, 'Search_invoices'])->name('Search_invoices');
    
    Route::post('Search_customers', [ReportsController::class, 'Search_customers'])->name('Search_customers');
    
    Route::get('MarkAsRead_all', [NotificationController::class,'markAllAsRead'])->name('MarkAsRead_all');
    
    Route::get('MarkAsRead/{id}/{da}', [NotificationController::class,'markAsRead'])->name('MarkAsRead');
});

require __DIR__.'/auth.php';

Route::get('/{page}', [AdminController::class, 'index'])->middleware(['auth']);

