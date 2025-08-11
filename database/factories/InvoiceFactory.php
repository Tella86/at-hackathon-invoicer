<?php
namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_number' => 'INV-' . fake()->unique()->randomNumber(6),
            'due_date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'status' => fake()->randomElement(['Draft', 'Sent', 'Paid', 'Overdue']),
            'total_amount' => 0, // We'll calculate this after creating items
        ];
    }

    /**
     * Configure the model factory.
     *
     * This method allows us to run logic AFTER an invoice and its items are created.
     *
     * @return static
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Invoice $invoice) {
            // Calculate the total amount from the invoice items and update the invoice
            $total = $invoice->items->sum(function (InvoiceItem $item) {
                return $item->quantity * $item->unit_price;
            });
            $invoice->update(['total_amount' => $total]);
        });
    }
}
