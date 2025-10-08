<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Define the main application routes here, using resourceful routing.
|
*/

// 1. Dashboard Route (Statistics)
// The root URL points to the dedicated DashboardController's index method.
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Customer Management (Resourceful CRUD)
// We use Route::resource to define standard CRUD routes for Customers.
// The `except` clause is used to keep it simple, omitting `create`, `edit`, and `update` views
// since we only implemented the index, store, show, and destroy logic.
Route::resource('customers', CustomerController::class)->except([
    'create',
]);

// 3. Invoice Management (Resourceful CRUD)
// We use Route::resource for Invoices as well.
// We omit `create`, `edit`, `update`, and `show` as we focus on the list view and quick creation/deletion.
Route::resource('invoices', InvoiceController::class)->except([
    'create',
    'show'
]);
