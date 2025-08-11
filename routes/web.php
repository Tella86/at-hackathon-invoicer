<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () { return view('welcome'); });

// Public route to view and pay an invoice
Route::get('/invoices/pay/{invoice}', [InvoiceController::class, 'showPublic'])->name('invoices.showPublic');
Route::post('/invoices/pay/{invoice}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resources
    Route::resource('clients', ClientController::class);
    Route::resource('invoices', InvoiceController::class);

    // Custom Invoice Actions
    Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');

});

require __DIR__.'/auth.php';
