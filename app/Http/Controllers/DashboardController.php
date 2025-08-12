<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_revenue' => $user->invoices()->where('status', 'Paid')->sum('total_amount'),
            'outstanding' => $user->invoices()->whereIn('status', ['Sent', 'Overdue'])->sum('total_amount'),
            'client_count' => $user->clients()->count(),
        ];

        $recentInvoices = $user->invoices()->with('client')->latest()->take(5)->get();

        // The user->registration_code will now exist thanks to our command
          $registrationLink = route('client.register.form', ['code' => $user->registration_code]);

    // Pass all data to the view
    return view('dashboard', compact('stats', 'recentInvoices', 'registrationLink'));
    }
}
