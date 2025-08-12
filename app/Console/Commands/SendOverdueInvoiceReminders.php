<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use AfricasTalking\SDK\AfricasTalking;

class SendOverdueInvoiceReminders extends Command
{
    protected $signature = 'invoices:remind';
    protected $description = 'Send SMS reminders for overdue invoices';

    public function handle()
    {
        $this->info('Checking for overdue invoices...');
        $overdueInvoices = Invoice::where('due_date', '<', now())
            ->where('status', 'Sent')->get(); // Only remind for sent, not draft/paid

        if ($overdueInvoices->isEmpty()) {
            $this->info('No overdue invoices found.');
            return 0;
        }

        $AT = new AfricasTalking(config('services.africastalking.username'), config('services.africastalking.api_key'));
        $sms = $AT->sms();

        foreach ($overdueInvoices as $invoice) {
            $message = "Hi {$invoice->client->name}, a reminder that invoice #{$invoice->invoice_number} for KES {$invoice->total_amount} is overdue.";
            try {
                $sms->send(['to' => $invoice->client->phone, 'message' => $message]);
                $invoice->update(['status' => 'Overdue']);
                $this->info("Reminder sent for invoice #{$invoice->invoice_number}");
            } catch (\Exception $e) {
                $this->error("Failed for invoice #{$invoice->invoice_number}: " . $e->getMessage());
            }
        }
        $this->info('Overdue reminder process complete.');
        return 0;
    }
}
