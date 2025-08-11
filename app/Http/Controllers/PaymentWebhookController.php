<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Payment webhook received:', $request->all());

        if ($request->input('status') === 'Success') {
            $invoiceId = $request->input('requestMetadata.invoice_id');
            $invoice = Invoice::find($invoiceId);
            if ($invoice && $invoice->status !== 'Paid') {
                $invoice->update(['status' => 'Paid']);
                Log::info("Invoice #{$invoiceId} marked as Paid.");
            }
        }
        return response('Success', 200);
    }
}
