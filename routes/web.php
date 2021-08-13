<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//main page is a login page
Route::get('/', function () {
    return view('auth.login');
});

//authentication routes
Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


################# invoices routes ##################################
Route::get('invoices', [\App\Http\Controllers\InvoicesController::class,'getAllInvoices'])->name('all.invoices');
Route::get('editInvoices', [\App\Http\Controllers\InvoicesController::class,'getEditInvoices'])->name('edit.invoice');
Route::get('section/{section_id}', [\App\Http\Controllers\InvoicesController::class,'getProducts'])->name('getSectionProducts');
Route::post('invoices/store', [\App\Http\Controllers\InvoicesController::class,'store']);
Route::get('invoice/edit/{invoice_id}', [\App\Http\Controllers\InvoicesController::class,'edit']);
Route::post('invoice/update', [\App\Http\Controllers\InvoicesController::class,'update']);
Route::get('invoice/delete/{invoice_id}', [\App\Http\Controllers\InvoicesController::class,'destroy']);
Route::get('invoice/editstatus/{invoice_id}', [\App\Http\Controllers\InvoicesController::class,'editStatus']);
Route::post('invoice/updatestatus', [\App\Http\Controllers\InvoicesController::class,'updateStatus'])->name('update.status.invoice');
Route::get('invoices/paid', [\App\Http\Controllers\InvoicesController::class,'paidInvoices'])->name('paid.invoices');
Route::get('invoices/unpaid', [\App\Http\Controllers\InvoicesController::class,'unpaidInvoices'])->name('unpaid.invoices');
Route::get('invoices/partpaid', [\App\Http\Controllers\InvoicesController::class,'partpaidInvoices'])->name('partpaid.invoices');

###################################################################

################# invoicesDetails routes ##################################
Route::get('archive/add/{invoice_id}', [\App\Http\Controllers\ArchiveController::class,'addToArchive'])->name('add.archive');
Route::get('archive/show', [\App\Http\Controllers\ArchiveController::class,'index'])->name('archive');
Route::get('archive/restore/{invoice_id}', [\App\Http\Controllers\ArchiveController::class,'restoreArchive']);
Route::get('archive/delete/{invoice_id}', [\App\Http\Controllers\ArchiveController::class,'destroy']);

###################################################################

################# invoicesDetails routes ##################################
Route::get('invoices/details/{invoice_id}', [\App\Http\Controllers\InvoicesDetailsController::class,'details'])->name('get.invoice.details');
Route::get('view-file/{file_name}', [\App\Http\Controllers\InvoicesDetailsController::class,'view_file']);
Route::get('download-file/{file_name}', [\App\Http\Controllers\InvoicesDetailsController::class,'download_file']);
Route::get('delete-file/{attachment_id}/{file_name}', [\App\Http\Controllers\InvoicesDetailsController::class,'delete_file']);
###################################################################

################# invoiceAttachment routes ##################################
Route::post('attachment/add', [\App\Http\Controllers\InvoicesAttachmentController::class,'store']);
###################################################################

################# sections routes ##################################
Route::get('sections', [\App\Http\Controllers\SectionsController::class,'getAllSections'])->name('all.sections');
Route::post('section/store', [\App\Http\Controllers\SectionsController::class,'store'])->name('store.section');
Route::get('delete/{section_id}', [\App\Http\Controllers\SectionsController::class,'destroy'])->name('delete.section');
Route::get('edit/{section_id}', [\App\Http\Controllers\SectionsController::class,'edit'])->name('edit.section');
Route::post('update', [\App\Http\Controllers\SectionsController::class,'update'])->name('update.section');
###################################################################

################# products routes ##################################
Route::get('products', [\App\Http\Controllers\ProductsController::class,'getAllProducts'])->name('all.products');
Route::post('store', [\App\Http\Controllers\ProductsController::class,'store'])->name('store.product');
Route::get('product/delete/{product_id}', [\App\Http\Controllers\ProductsController::class,'destroy'])->name('delete.product');
Route::get('product/edit/{product_id}', [\App\Http\Controllers\ProductsController::class,'edit'])->name('edit.product');
Route::post('product/update', [\App\Http\Controllers\ProductsController::class,'update'])->name('update.product');
###################################################################

################# roles and permissions routes ##################################
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
});
###################################################################

//get all pages
Route::get('/{page}', [\App\Http\Controllers\AdminController::class,'index']);
