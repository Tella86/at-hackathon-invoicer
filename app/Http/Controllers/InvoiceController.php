<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Auth; // <--- MAKE SURE THIS LINE IS HERE

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // THIS IS THE CORRECTED CODE
        // 1. Get the authenticated user.
        // 2. Call the invoices() relationship on the user object.
        $invoices = Auth::user()->invoices()->with('client')->latest()->get();

        // Pass the fetched invoices to the view.
        return view('invoices.index', compact('invoices'));
    }

    // ... The rest of your controller methods (create, store, etc.)
    public function create() {
        $clients = Auth::user()->clients;
        return view('invoices.create', compact('clients'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($data['items'] as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        try {
            DB::beginTransaction();
            $invoice = Auth::user()->invoices()->create([
                'client_id' => $data['client_id'],
                'due_date' => $data['due_date'],
                'invoice_number' => 'INV-' . time(), // Simple unique number
                'total_amount' => $totalAmount,
                'status' => 'Draft',
            ]);

            foreach ($data['items'] as $item) {
                $invoice->items()->create($item);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created.');
    }

    public function showPublic(Invoice $invoice) {
        return view('invoices.show_public', compact('invoice'));
    }

    public function send(Invoice $invoice) {
        $username    = config('services.africastalking.username');
        $apiKey      = config('services.africastalking.api_key');
        $productName = config('services.africastalking.product_name');

        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();

        $paymentLink = route('invoices.showPublic', $invoice);
        $message = "Hi {$invoice->client->name}, new invoice #{$invoice->invoice_number} for KES {$invoice->total_amount} is ready. Pay here: {$paymentLink}";

        try {
            $sms->send(['to' => $invoice->client->phone, 'message' => $message]);
            $invoice->update(['status' => 'Sent']);
            return back()->with('success', 'Invoice sent via SMS!');
        } catch (\Exception $e) {
            return back()->with('error', 'SMS failed: '.$e->getMessage());
        }
    }

}
