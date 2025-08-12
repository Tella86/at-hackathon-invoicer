<!-- This is a public page, so no auth layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Print-specific styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
            .print-border {
                border: 1px solid black !important;
            }
            .shadow-lg {
                box-shadow: none !important;
            }
            .bg-gray-100 {
                background-color: white !important;
            }
            table {
                border: 1px solid black !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-10 print-border">

        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Invoice</h1>
                <p class="text-sm text-gray-500">#{{ $invoice->invoice_number }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Due Date</p>
                <p class="text-lg font-semibold">{{ $invoice->due_date->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Client Info -->
        <div class="mb-6">
            <p class="font-semibold text-gray-700">Billed To:</p>
            <p class="text-gray-600">{{ $invoice->client->name }}</p>
        </div>

        <!-- Status -->
        <div class="mb-6">
            <span class="px-3 py-1 text-sm rounded-full
                @if($invoice->status === 'Paid') bg-green-100 text-green-700
                @elseif($invoice->status === 'Pending') bg-yellow-100 text-yellow-700
                @else bg-red-100 text-red-700 @endif">
                {{ $invoice->status }}
            </span>
        </div>

        <!-- Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left py-2 px-4 border border-gray-200">Description</th>
                        <th class="text-center py-2 px-4 border border-gray-200">Qty</th>
                        <th class="text-right py-2 px-4 border border-gray-200">Price (KES)</th>
                        <th class="text-right py-2 px-4 border border-gray-200">Total (KES)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach($invoice->items as $item)
                    @php
                        $lineTotal = $item->quantity * $item->unit_price;
                        $subtotal += $lineTotal;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border border-gray-200">{{ $item->description }}</td>
                        <td class="text-center py-2 px-4 border border-gray-200">{{ $item->quantity }}</td>
                        <td class="text-right py-2 px-4 border border-gray-200">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right py-2 px-4 border border-gray-200">{{ number_format($lineTotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        @php
            $vat = $subtotal * 0.16; // 16% VAT
            $grandTotal = $subtotal + $vat;
        @endphp
        <div class="flex justify-end mt-6">
            <div class="text-right space-y-1">
                <p class="text-sm text-gray-500">Subtotal: <span class="font-semibold">KES {{ number_format($subtotal, 2) }}</span></p>
                <p class="text-sm text-gray-500">VAT (16%): <span class="font-semibold">KES {{ number_format($vat, 2) }}</span></p>
                <p class="text-lg font-bold text-gray-800">Grand Total: KES {{ number_format($grandTotal, 2) }}</p>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="mt-8 no-print">
            @if($invoice->status !== 'Paid')
                <form action="{{ route('payment.initiate', $invoice) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-blue-700 transition">
                        Pay Now with Mobile Money
                    </button>
                </form>
            @else
                <p class="text-green-700 font-semibold text-center bg-green-50 py-3 rounded-lg">
                    This invoice has been paid. Thank you!
                </p>
            @endif
        </div>

        <!-- Print Button -->
        <div class="mt-4 text-center no-print">
            <button onclick="window.print()"
                class="px-6 py-2 bg-gray-700 text-white rounded-lg shadow hover:bg-gray-800">
                Print Invoice
            </button>
            <a href="{{ route('invoice.download', $invoice) }}"
   class="no-print px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
   Download PDF
</a>

        </div>
    </div>
</body>
</html>
