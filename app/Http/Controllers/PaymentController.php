<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;

class PaymentController extends Controller
{
    public function initiate(Request $request, Invoice $invoice)
    {
        $AT = new AfricasTalking(env('AFRICASTALKING_USERNAME'), env('AFRICASTALKING_API_KEY'));
        $payments = $AT->payments();

        try {
            $response = $payments->mobileCheckout([
                'productName'   => env('AFRICASTALKING_PRODUCT_NAME'),
                'phoneNumber'   => $invoice->client->phone,
                'currencyCode'  => 'KES',
                'amount'        => $invoice->total_amount,
                'metadata'      => ['invoice_id' => $invoice->id]
            ]);
            return back()->with('success', 'STK push sent. Please enter your PIN.');
        } catch(\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
