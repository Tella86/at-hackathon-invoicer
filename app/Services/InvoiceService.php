<?php
namespace App\Services;

use App\Models\Invoice;
use AfricasTalking\SDK\AfricasTalking;
use Exception;
use Illuminate\Support\Facades\Log;

class InvoiceService
{
    protected $africasTalking;

    public function __construct()
    {
        // Initialize the SDK once in the constructor
        $this->africasTalking = new AfricasTalking(
            env('AFRICASTALKING_USERNAME'),
            env('AFRICASTALKING_API_KEY')
        );
    }

    /**
     * Send an invoice notification via SMS.
     *
     * @param Invoice $invoice
     * @return bool True on success, false on failure.
     */
    public function sendInvoiceViaSms(Invoice $invoice): bool
    {
        $sms = $this->africasTalking->sms();
        $paymentLink = route('invoices.showPublic', $invoice);
        $message = "Hi {$invoice->client->name}, new invoice #{$invoice->invoice_number} for KES {$invoice->total_amount} is ready. Pay here: {$paymentLink}";

        try {
            $sms->send(['to' => $invoice->client->phone, 'message' => $message]);
            $invoice->update(['status' => 'Sent']);
            return true;
        } catch (Exception $e) {
            Log::error('SMS sending failed for invoice ' . $invoice->id, ['error' => $e->getMessage()]);
            return false;
        }
    }
}
