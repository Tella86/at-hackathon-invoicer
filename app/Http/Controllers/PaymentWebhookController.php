<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use AfricasTalking\SDK\AfricasTalking;

class PaymentWebhookController extends Controller
{
    // app/Http/Controllers/PaymentWebhookController.php

public function handle(Request $request)
{
    // Check if the transaction was successful
    if ($request->input('status') === 'Success') {
        $invoiceId = $request->input('requestMetadata.invoice_id');
        $transactionId = $request->input('transactionId');

        // Find the invoice using the metadata we sent
        $invoice = Invoice::find($invoiceId);

        if ($invoice && $invoice->status !== 'Paid') {
            // Update the invoice status to 'Paid'
            $invoice->update(['status' => 'Paid']);

            // Optional: Send a confirmation SMS to the SME owner or client
            // ... your SMS sending logic here ...
        }
    }

    // Acknowledge receipt of the webhook to Africa's Talking
    return response('Success', 200);
}
// app/Http/Controllers/PaymentController.php


public function initiate(Request $request, Invoice $invoice)
{
    $username = config('services.africastalking.username');
    $apiKey = config('services.africastalking.api_key');
    $AT = new AfricasTalking($username, $apiKey);
    $payments = $AT->payments();

    $productName = config('services.africastalking.product_name');
    $phoneNumber = $invoice->client->phone; // Ensure it's in +254 format
    $currencyCode = 'KES';
    $amount = $invoice->total_amount;

    // Use the invoice ID in metadata to identify it in the webhook
    $metadata = ['invoice_id' => $invoice->id];

    try {
        $response = $payments->mobileCheckout([
            'productName'   => $productName,
            'phoneNumber'   => $phoneNumber,
            'currencyCode'  => $currencyCode,
            'amount'        => $amount,
            'metadata'      => $metadata
        ]);

        // The user will receive an STK push on their phone
        return back()->with('success', 'Payment prompt sent to your phone. Please complete the transaction.');

    } catch(Exception $e) {
        return back()->with('error', 'Error initiating payment: '.$e->getMessage());
    }
}
}
