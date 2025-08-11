<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use AfricasTalking\SDK\AfricasTalking;

class SendOverdueInvoiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-overdue-invoice-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    // In the handle() method
public function handle()
{
    $this->info('Checking for overdue invoices...');

    // Find invoices that are past their due_date and are not yet 'Paid'
    $overdueInvoices = Invoice::where('due_date', '<', now())
                              ->where('status', '!=', 'Paid')
                              ->get();

    if ($overdueInvoices->isEmpty()) {
        $this->info('No overdue invoices found.');
        return 0;
    }

    // Initialize Africa's Talking SDK
    $username = config('services.africastalking.username');
    $apiKey   = config('services.africastalking.api_key');
    $AT       = new AfricasTalking($username, $apiKey);
    $sms      = $AT->sms();

    foreach ($overdueInvoices as $invoice) {
        $message = "Hi {$invoice->client->name}, a friendly reminder that your invoice #{$invoice->invoice_number} for KES {$invoice->total_amount} is overdue. Please pay soon.";

        try {
            $sms->send([
                'to'      => $invoice->client->phone,
                'message' => $message
            ]);
            $this->info("Reminder sent for invoice #{$invoice->invoice_number}");
        } catch (Exception $e) {
            $this->error("Failed to send reminder for invoice #{$invoice->invoice_number}: " . $e->getMessage());
        }
    }

    $this->info('Overdue reminder process complete.');
    return 0;
}
}
