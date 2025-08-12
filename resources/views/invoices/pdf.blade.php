<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h1 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_number }}</h1>
    <p><strong>Billed To:</strong> {{ $invoice->client->name }}</p>
    <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
    <p><strong>Status:</strong> {{ $invoice->status }}</p>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align:center">Qty</th>
                <th style="text-align:right">Price (KES)</th>
                <th style="text-align:right">Total (KES)</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($invoice->items as $item)
                @php
                    $lineTotal = $item->quantity * $item->unit_price;
                    $subtotal += $lineTotal;
                @endphp
                <tr>
                    <td>{{ $item->description }}</td>
                    <td style="text-align:center">{{ $item->quantity }}</td>
                    <td style="text-align:right">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align:right">{{ number_format($lineTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $vat = $subtotal * 0.16;
        $grandTotal = $subtotal + $vat;
    @endphp

    <p><strong>Subtotal:</strong> KES {{ number_format($subtotal, 2) }}</p>
    <p><strong>VAT (16%):</strong> KES {{ number_format($vat, 2) }}</p>
    <p><strong>Grand Total:</strong> KES {{ number_format($grandTotal, 2) }}</p>
</body>
</html>
