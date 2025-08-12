<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\ClientAuthController;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// --- Publicly Accessible Routes ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/invoices/pay/{invoice}', [InvoiceController::class, 'showPublic'])->name('invoices.showPublic');
Route::post('/invoices/pay/{invoice}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
 Route::get('/invoice/{invoice}/download', function (Invoice $invoice) {
    $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
    return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
})->name('invoice.download');

// --- Business User Authentication Routes (Main App) ---
// Note: The default `auth.php` file provides login, register, etc. for this guard.
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Management
    Route::resource('clients', ClientController::class);
    Route::resource('invoices', InvoiceController::class);

    // Custom Actions
    Route::post('/invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send');
    Route::post('/clients/{client}/send-airtime', [AirtimeController::class, 'send'])->name('clients.sendAirtime');

    // Action to send an invitation to a client
    Route::post('/clients/{client}/invite', [ClientController::class, 'invite'])->name('clients.invite');
});


// --- Client Portal Authentication & Registration Routes ---
Route::prefix('client')->name('client.')->group(function () {

    // Routes for GUESTS (clients who are NOT logged in)
    Route::middleware('guest:client')->group(function () {
        // Login Routes
        Route::get('login', [ClientAuthController::class, 'showLoginForm'])->name('login.form');
        Route::post('login', [ClientAuthController::class, 'login'])->name('login');

        // Invitation Routes
        Route::get('invitation/{token}', [ClientAuthController::class, 'showAcceptForm'])->name('invitation.accept');
        Route::post('invitation', [ClientAuthController::class, 'processAcceptForm'])->name('invitation.store');

        // --- NEW: Self-Registration Routes ---
        Route::get('register/{code}', [ClientAuthController::class, 'showRegistrationForm'])->name('register.form');
        Route::post('register', [ClientAuthController::class, 'register'])->name('register');
    });

    // Routes for AUTHENTICATED clients
    Route::middleware('auth:client')->group(function () {
        Route::post('logout', [ClientAuthController::class, 'logout'])->name('logout');

        // This is where all client portal pages will go
        Route::get('dashboard', function () {
            // Logic for the client dashboard will go here or in a dedicated controller
            $client = auth('client')->user();
            $invoices = $client->invoices()->latest()->paginate(10);
            return view('client.dashboard', compact('invoices'));
        })->name('dashboard');

        Route::get('invoices/{invoice}', function(\App\Models\Invoice $invoice){
            // Ensure the authenticated client owns this invoice
            if (auth('client')->id() !== $invoice->client_id) {
                abort(403);
            }
            return view('client.invoice-details', compact('invoice'));
        })->name('invoice.show');

    });


});


// This file contains the default registration, login, password reset etc. routes for the main 'web' guard.
require __DIR__.'/auth.php';
