<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use AfricasTalking\SDK\AfricasTalking;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


public function send(Invoice $invoice)
{
    // Initialize the SDK
    $username = config('services.africastalking.username');
    $apiKey = config('services.africastalking.api_key');
    $AT = new AfricasTalking($username, $apiKey);
    $sms = $AT->sms();

    // Compose the message
    $clientName = $invoice->client->name;
    $amount = $invoice->total_amount;
    $invoiceNumber = $invoice->invoice_number;
    $paymentLink = route('invoices.show', $invoice); // A public page to view & pay

    $message = "Hi {$clientName}, you have a new invoice (#{$invoiceNumber}) for KES {$amount}. View and pay here: {$paymentLink}";

    try {
        $result = $sms->send([
            'to'      => $invoice->client->phone,
            'message' => $message
        ]);

        // Update invoice status to 'Sent'
        $invoice->update(['status' => 'Sent']);

        return back()->with('success', 'Invoice sent successfully!');
    } catch (Exception $e) {
        return back()->with('error', 'SMS could not be sent: '.$e->getMessage());
    }
}
}
