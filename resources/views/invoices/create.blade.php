<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Invoice</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('invoices.store') }}" id="invoice-form">
                    @csrf
                    <!-- Client & Due Date -->
                    <div>
                        <label for="client_id">Client</label>
                        <select name="client_id" required>
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="due_date">Due Date</label>
                        <input type="date" name="due_date" required>
                    </div>

                    <!-- Invoice Items -->
                    <hr class="my-4">
                    <h3>Invoice Items</h3>
                    <div id="invoice-items">
                        <div class="item">
                            <input type="text" name="items[0][description]" placeholder="Description" required>
                            <input type="number" name="items[0][quantity]" placeholder="Qty" value="1" required>
                            <input type="number" step="0.01" name="items[0][unit_price]" placeholder="Unit Price" required>
                        </div>
                    </div>
                    <button type="button" id="add-item" class="mt-2">Add Another Item</button>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple JS to add more item rows
        document.getElementById('add-item').addEventListener('click', function() {
            const itemsContainer = document.getElementById('invoice-items');
            const index = itemsContainer.children.length;
            const newItem = document.createElement('div');
            newItem.classList.add('item', 'mt-2');
            newItem.innerHTML = `
                <input type="text" name="items[${index}][description]" placeholder="Description" required>
                <input type="number" name="items[${index}][quantity]" placeholder="Qty" value="1" required>
                <input type="number" step="0.01" name="items[${index}][unit_price]" placeholder="Unit Price" required>
            `;
            itemsContainer.appendChild(newItem);
        });
    </script>
</x-app-layout>
