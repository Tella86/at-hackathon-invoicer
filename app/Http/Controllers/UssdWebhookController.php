<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;

class UssdWebhookController extends Controller
{


    public function handle(Request $request)
    {
        $sessionId   = $request->input('sessionId');
        $phoneNumber = $request->input('phoneNumber');
        $text        = $request->input('text'); // This contains the user's input

        // Find the client by their phone number
        $client = Client::where('phone', $phoneNumber)->first();

        if (!$client) {
            $response = "END Sorry, your phone number is not registered with any business.";
        } else {
            // Find the latest unpaid invoice for this client
            $invoice = Invoice::where('client_id', $client->id)
                              ->where('status', '!=', 'Paid')
                              ->latest()
                              ->first();

            if ($invoice) {
                $response = "END Hi {$client->name}. Your outstanding balance for invoice #{$invoice->invoice_number} is KES {$invoice->total_amount}.";
            } else {
                $response = "END Hi {$client->name}. You have no outstanding invoices. Thank you!";
            }
        }

        // Send the response back to Africa's Talking
        return response($response)->header('Content-Type', 'text/plain');
    }
}
