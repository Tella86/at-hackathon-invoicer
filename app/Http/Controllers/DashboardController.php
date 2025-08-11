<?php
namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        return view('dashboard', compact('stats', 'recentInvoices'));
    }
}
