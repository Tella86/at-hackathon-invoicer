<!-- This is a public page, so no auth layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <!-- Add simple styling or Tailwind CDN -->
</head>
<body>
    <div>
        <h1>Invoice #{{ $invoice->invoice_number }}</h1>
        <p><strong>To:</strong> {{ $invoice->client->name }}</p>
        <p><strong>Status:</strong> {{ $invoice->status }}</p>
        <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>

        <table>
            <thead><tr><th>Description</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total Amount: KES {{ number_format($invoice->total_amount, 2) }}</h3>

        @if($invoice->status !== 'Paid')
            <form action="{{ route('payment.initiate', $invoice) }}" method="POST">
                @csrf
                <button type="submit">Pay Now with Mobile Money</button>
            </form>
        @else
            <p><strong>This invoice has been paid. Thank you!</strong></p>
        @endif
    </div>
</body>
</html>
