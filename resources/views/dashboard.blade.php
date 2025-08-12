<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Invoice
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages for user feedback -->
            <div class="mb-6">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <p class="font-bold">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                 @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Revenue Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0l.879-.659M7.5 14.25l6-6M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium uppercase">Total Revenue</h3>
                        <p class="text-2xl font-bold mt-1">KES {{ number_format($stats['total_revenue'], 2) }}</p>
                    </div>
                </div>
                <!-- Outstanding Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium uppercase">Outstanding</h3>
                        <p class="text-2xl font-bold mt-1">KES {{ number_format($stats['outstanding'], 2) }}</p>
                    </div>
                </div>
                <!-- Total Clients Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center">
                     <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962c.513-.513.513-1.345 0-1.858l-1.858-1.858c-.513-.513-1.345-.513-1.858 0M10.5 18.252a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM12.91 15.06a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM17.085 12.44a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM9.01 9.06a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM12.91 6.36a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM16.085 3.66a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium uppercase">Total Clients</h3>
                        <p class="text-2xl font-bold mt-1">{{ $stats['client_count'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Area (Two Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Recent Invoices (NOW WITH THE INTERACTIVE TABLE) -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Recent Invoices</h3>
                                <a href="{{ route('invoices.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                    View All &rarr;
                                </a>
                            </div>

                            @if($recentInvoices->isEmpty())
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No invoices</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new invoice.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                            Create First Invoice
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($recentInvoices as $invoice)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $invoice->client->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $invoice->invoice_number }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        KES {{ number_format($invoice->total_amount, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            @if($invoice->status == 'Paid') bg-green-100 text-green-800 @endif
                                                            @if($invoice->status == 'Sent' || $invoice->status == 'Overdue') bg-yellow-100 text-yellow-800 @endif
                                                            @if($invoice->status == 'Draft') bg-gray-100 text-gray-800 @endif">
                                                            {{ $invoice->status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <div class="flex items-center justify-end space-x-4">
                                                            @if($invoice->status == 'Draft' || $invoice->status == 'Sent' || $invoice->status == 'Overdue')
                                                                <form action="{{ route('invoices.send', $invoice) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" title="Send SMS" class="text-gray-400 hover:text-indigo-600">
                                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('invoices.showPublic', $invoice) }}" target="_blank" title="View Public Invoice" class="text-gray-400 hover:text-indigo-600">
                                                                 <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-4.5 0V6.75A2.25 2.25 0 0115.75 4.5h1.5m-4.5 0h-1.5a2.25 2.25 0 00-2.25 2.25v1.5m-4.5 0h1.5a2.25 2.25 0 012.25-2.25h1.5" /></svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Actions -->
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold">Onboard New Clients</h3>
                        <p class="mt-2 text-sm text-gray-600">Share this unique link with clients so they can create their portal account.</p>

                        <div class="mt-4">
                            <label for="registration-link" class="sr-only">Registration Link</label>
                            <div class="relative">
                                <input id="registration-link" type="text" value="{{ $registrationLink }}" readonly class="w-full p-2 border border-gray-300 rounded-md bg-gray-50 pr-16">
                                <button onclick="copyToClipboard()" id="copy-button" class="absolute inset-y-0 right-0 px-3 flex items-center bg-gray-200 text-gray-600 text-xs font-bold uppercase rounded-r-md hover:bg-gray-300">
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const linkInput = document.getElementById('registration-link');
            const copyButton = document.getElementById('copy-button');

            linkInput.select();
            linkInput.setSelectionRange(0, 99999); // For mobile devices

            navigator.clipboard.writeText(linkInput.value);

            // Provide visual feedback
            copyButton.innerText = 'Copied!';
            setTimeout(() => {
                copyButton.innerText = 'Copy';
            }, 2000);
        }
    </script>
</x-app-layout>
