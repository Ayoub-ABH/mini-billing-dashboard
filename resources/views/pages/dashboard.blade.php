@extends('app')
@section('title', 'home')
@section('content')

<h1 class="text-3xl font-bold text-gray-900 tracking-tight mb-8">System Overview</h1>

    <!-- Key Metrics Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        @php
            $metrics = [
                ['title' => 'Total Customers', 'value' => number_format($stats['total_customers']), 'color' => 'blue', 'icon_path' => 'M17 20h-12c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2h12c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2zM12 6c1.1 0 2-.9 2-2h-4c-1.1 0-2 .9-2 2v1h4z'],
                ['title' => 'Total Invoices', 'value' => number_format($stats['total_invoices']), 'color' => 'indigo', 'icon_path' => 'M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm1 15h-2v-6h-2V7h4v4h2v6z'],
                ['title' => 'Pending Revenue', 'value' => '$' . number_format($stats['pending_revenue'], 2), 'color' => 'yellow', 'icon_path' => 'M12 1.75l-10.25 4.75V17c0 2.2 1.5 4 4.5 4h11.5c3 0 4.5-1.8 4.5-4V6.5l-10.25-4.75zm0 2.37l7.5 3.49-7.5 3.49-7.5-3.49 7.5-3.49zm-8.5 6.49l8.5 4 8.5-4V17c0 1.5-.9 2.5-2.5 2.5H6c-1.6 0-2.5-1-2.5-2.5V10.59z'],
                ['title' => 'Collected Revenue', 'value' => '$' . number_format($stats['collected_revenue'], 2), 'color' => 'emerald', 'icon_path' => 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z'],
            ];
        @endphp

        @foreach ($metrics as $metric)
        <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 transition-all hover:ring-2 ring-{{ $metric['color'] }}-200">
            <div class="flex items-center">
                <!-- Using inline SVG for speed and visual appeal -->
                <svg class="h-6 w-6 text-{{ $metric['color'] }}-500 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $metric['icon_path'] }}" /></svg>
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ $metric['title'] }}</p>
                    <p class="mt-1 text-3xl font-bold text-gray-900">{{ $metric['value'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </section>

    <!-- Recent Activity Table -->
    <section class="mt-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Recent Invoice Activity</h2>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
             <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($recentInvoices as $invoice)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('customers.show', $invoice->customer) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $invoice->customer->name ?? 'N/A' }}
                                </a>
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
                        <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent invoices found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
