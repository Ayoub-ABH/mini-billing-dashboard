@extends('app')
@section('title', 'invoices')
@section('content')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight mb-4 sm:mb-0">Invoice Management</h1>
        <button onclick="document.getElementById('add-invoice-form').classList.toggle('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow-lg transition duration-150 flex items-center">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M13 14h-2V7h-2v7H7v2h6v-2h-2zM9 4V3h2v1h4v1H5V4h4z"/></svg>
            Create New Invoice
        </button>
    </div>

    <!-- Create Invoice Form (Toggles visibility) -->
    <div id="add-invoice-form" class="hidden mb-8 p-6 bg-white rounded-2xl shadow-xl border border-gray-100">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Create New Invoice</h3>
        <form action="{{ route('invoices.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <div class="md:col-span-2">
                <select name="customer_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('customer_id') border-red-500 @enderror">
                    <option value="">-- Select Customer --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="text" name="invoice_number" placeholder="Invoice Number" required value="{{ old('invoice_number') }}" class="w-full p-3 border border-gray-300 rounded-lg @error('invoice_number') border-red-500 @enderror">
            </div>
            <div>
                <select name="status" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Paid" {{ old('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Late" {{ old('status') == 'Late' ? 'selected' : '' }}>Late</option>
                    <option value="Void" {{ old('status') == 'Void' ? 'selected' : '' }}>Void</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <input type="number" step="0.01" name="amount" placeholder="Amount (e.g., 125.50)" required value="{{ old('amount') }}" class="w-full p-3 border border-gray-300 rounded-lg @error('amount') border-red-500 @enderror">
            </div>
            <div>
                <label for="invoice_date" class="text-xs text-gray-500 block mb-1">Invoice Date</label>
                <input type="date" name="invoice_date" id="invoice_date" required value="{{ old('invoice_date') }}" class="w-full p-3 border border-gray-300 rounded-lg @error('invoice_date') border-red-500 @enderror">
            </div>
            <div>
                <label for="due_date" class="text-xs text-gray-500 block mb-1">Due Date</label>
                <input type="date" name="due_date" id="due_date" required value="{{ old('due_date') }}" class="w-full p-3 border border-gray-300 rounded-lg @error('due_date') border-red-500 @enderror">
            </div>
            <div class="md:col-span-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-150">
                    Finalize & Create Invoice
                </button>
            </div>
        </form>
         @if ($errors->any())
            <script>document.getElementById('add-invoice-form').classList.remove('hidden');</script>
        @endif
    </div>

    <!-- Invoice List Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($invoices as $invoice)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('customers.show', $invoice->customer) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                {{ $invoice->customer->name ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="{{ $invoice->due_date->isPast() && $invoice->status == 'Pending' ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                {{ $invoice->due_date->format('M d, Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-800">
                            ${{ number_format($invoice->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full border badge-{{ $invoice->status }}">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <!-- Edit (inline) -->
                            <button type="button" onclick="document.getElementById('edit-row-{{ $invoice->id }}').classList.toggle('hidden')" class="text-indigo-600 hover:text-indigo-800 p-1 mr-2" title="Edit Invoice">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9a1 1 0 01-.464.263l-4 1a1 1 0 01-1.212-1.212l1-4a1 1 0 01.263-.464l9.9-9.9a2 2 0 012.828 0z" />
                                </svg>
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete invoice {{ $invoice->invoice_number }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-colors" title="Delete Invoice">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Inline edit row (hidden by default) -->
                    <tr id="edit-row-{{ $invoice->id }}" class="hidden bg-gray-50">
                        <td colspan="6" class="px-6 py-4">
                            <form action="{{ route('invoices.update', $invoice) }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="invoice_number" value="{{ $invoice->invoice_number }}" />

                                <div class="md:col-span-2">
                                    <label class="text-xs text-gray-500">Customer</label>
                                    <select name="customer_id" required class="w-full p-2 border border-gray-300 rounded @error('customer_id') border-red-500 @enderror">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->email }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="text-xs text-gray-500">Invoice Date</label>
                                    <input type="date" name="invoice_date" value="{{ old('invoice_date', optional($invoice->invoice_date)->format('Y-m-d')) }}" class="w-full p-2 border rounded" />
                                </div>

                                <div class="md:col-span-1">
                                    <label class="text-xs text-gray-500">Due Date</label>
                                    <input type="date" name="due_date" value="{{ old('due_date', optional($invoice->due_date)->format('Y-m-d')) }}" class="w-full p-2 border rounded" />
                                </div>


                                <div class="md:col-span-2">
                                    <label class="text-xs text-gray-500">Amount</label>
                                    <input type="number" step="0.01" name="amount" value="{{ old('amount', $invoice->amount) }}" class="w-full p-2 border rounded" />
                                </div>

                                <div class="md:col-span-1">
                                    <label class="text-xs text-gray-500">Status</label>
                                    <select name="status" class="w-full p-2 border rounded">
                                        <option value="Pending" {{ old('status', $invoice->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Paid" {{ old('status', $invoice->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="Late" {{ old('status', $invoice->status) == 'Late' ? 'selected' : '' }}>Late</option>
                                        <option value="Void" {{ old('status', $invoice->status) == 'Void' ? 'selected' : '' }}>Void</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1 flex space-x-2">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded">Save</button>
                                    <button type="button" onclick="document.getElementById('edit-row-{{ $invoice->id }}').classList.add('hidden')" class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded">Cancel</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No invoices found. Create one above!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
@endsection
