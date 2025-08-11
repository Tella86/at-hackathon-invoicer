<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Total Revenue</h3>
                    <p class="text-3xl font-bold mt-2">KES {{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Outstanding</h3>
                    <p class="text-3xl font-bold mt-2">KES {{ number_format($stats['outstanding'], 2) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-gray-500 text-sm font-medium uppercase">Total Clients</h3>
                    <p class="text-3xl font-bold mt-2">{{ $stats['client_count'] }}</p>
                </div>
            </div>

            <!-- Recent Invoices -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Recent Invoices</h3>
                    <!-- Paste the styled table from Part 1 here, but loop through $recentInvoices -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
