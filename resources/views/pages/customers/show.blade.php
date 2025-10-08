@extends('app')
@section('title', 'customers')
@section('content')

@section('content')
    <div class="mb-6">
        <a href="{{ route('customers.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Customer List
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $customer->name }}</h1>
        <p class="text-lg text-gray-500">{{ $customer->email }}</p>
    </div>

    <!-- Customer Details Card -->
    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Customer Details</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">
            <div>
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ $customer->email }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ $customer->phone ?? 'N/A' }}</dd>
            </div>
            <div class="col-span-full">
                <dt class="text-sm font-medium text-gray-500">Address</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ $customer->address ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>

    <!-- Invoices List -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Invoices for {{ $customer->name }} ({{ $customer->invoices->count() }})</h2>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($customer->invoices as $invoice)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $invoice->invoice_date->format('M d, Y') }}</td>
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
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">This customer has no invoices yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
