<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;
use Exception; // The fix is here

class PaymentController extends Controller
{
    public function initiate(Request $request, Invoice $invoice)
    {
        // ✅ Load credentials from config/services.php
        $username    = config('services.africastalking.username');
        $apiKey      = config('services.africastalking.api_key');
        $productName = config('services.africastalking.product_name');

        // Log safe details for debugging
        Log::info("Africa's Talking Config Check:", [
            'username'    => $username,
            'productName' => $productName,
            'hasApiKey'   => !empty($apiKey) ? 'YES' : 'NO'
        ]);

        // Validate credentials
        if (empty($username) || empty($apiKey) || empty($productName)) {
            Log::error("Africa's Talking credentials missing in config/services.php");
            return back()->with('error', 'Server configuration error. Please contact support.');
        }

        // Initialize SDK
        $AT = new AfricasTalking($username, $apiKey);
        $payments = $AT->payments();

        // Prepare request details
        $phoneNumber  = $invoice->client->phone;
        $currencyCode = 'KES';
        $amount       = (float) $invoice->total_amount;
        $metadata     = [
            'invoice_id'  => (string) $invoice->id,
            'client_name' => $invoice->client->name
        ];

        try {
            // Mobile Checkout Request
            $response = $payments->mobileCheckout([
                'productName'   => $productName,
                'phoneNumber'   => $phoneNumber,
                'currencyCode'  => $currencyCode,
                'amount'        => $amount,
                'metadata'      => $metadata
            ]);

            Log::info("Africa's Talking Payment Response:", (array) $response);

            // This part is redundant as the SDK throws an exception on failure now,
            // but we can leave it as a fallback.
            if (isset($response['status']) && $response['status'] === 'Success') {
                return back()->with('success', 'STK push sent successfully. Please enter your PIN on your phone.');
            } else {
                $description = $response['description'] ?? 'An unknown error occurred.';
                Log::error("Africa's Talking Payment Failed: " . $description);
                return back()->with('error', 'Could not initiate payment: ' . $description);
            }

        } catch (Exception $e) {
            // This block will catch any exceptions from the SDK, including the 401 error.
            Log::error("Africa's Talking SDK Exception: " . $e->getMessage());
            return back()->with('error', 'A critical error occurred. Please check the logs.');
        }
    }
}
