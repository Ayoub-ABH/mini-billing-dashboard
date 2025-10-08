@extends('app')
@section('title', 'customers')
@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight mb-4 sm:mb-0">Customer Management</h1>
        <!-- Toggle form visibility (simple JS/Alpine.js approach for quick UI) -->
        <button onclick="document.getElementById('add-customer-form').classList.toggle('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow-lg transition duration-150 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Add New Customer
        </button>
    </div>

    <!-- Add Customer Form (Toggles visibility) -->
    <div id="add-customer-form" class="hidden mb-8 p-6 bg-white rounded-2xl shadow-xl border border-gray-100">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Add New Customer</h3>
        <form action="{{ route('customers.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <div class="sm:col-span-2 lg:col-span-2">
                <input type="text" name="name" placeholder="Full Name" required value="{{ old('name') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            </div>
            <div>
                <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
            </div>
            <div>
                <input type="tel" name="phone" placeholder="+212612345678" pattern="^\+212\d{9}$" inputmode="tel" value="{{ old('phone') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror" title="Moroccan number in international format: +212 followed by 9 digits (e.g. +212612345678)">
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <input type="text" name="address" placeholder="Address" value="{{ old('address') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">
            </div>
            <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-150">
                    Create Customer
                </button>
            </div>
        </form>
        @if ($errors->any())
            <script>document.getElementById('add-customer-form').classList.remove('hidden');</script>
        @endif
    </div>

    <!-- Customer List Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Invoices</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <!-- Mandatory Button to see Invoices (links to customers.show) -->
                            <a href="{{ route('customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition duration-150">
                                View ({{ $customer->invoices_count }})
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full {{ $customer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $customer->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <!-- Edit button: toggles inline edit form -->
                            <button type="button" onclick="document.getElementById('edit-form-{{ $customer->id }}').classList.toggle('hidden')" class="text-indigo-600 hover:text-indigo-900 p-1 transition-colors" title="Edit Customer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9A1 1 0 016 16H3a1 1 0 01-1-1v-3a1 1 0 01.293-.707l9.9-9.9a2 2 0 012.828 0l2.393 2.393z" />
                                </svg>
                            </button>

                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('WARNING: Are you sure you want to delete {{ $customer->name }}? This will DELETE all {{ $customer->invoices_count }} associated invoices.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-colors" title="Delete Customer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Inline Edit Form Row (hidden by default) -->
                    <tr id="edit-form-{{ $customer->id }}" class="hidden bg-gray-50">
                        <td colspan="5" class="px-6 py-4">
                            <form action="{{ route('customers.update', $customer) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                                @csrf
                                @method('PUT')

                                <div class="sm:col-span-2 lg:col-span-2">
                                    <label class="sr-only" for="name-{{ $customer->id }}">Name</label>
                                    <input id="name-{{ $customer->id }}" type="text" name="name" placeholder="Full Name" required value="{{ old('name', $customer->name) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="sr-only" for="email-{{ $customer->id }}">Email</label>
                                    <input id="email-{{ $customer->id }}" type="email" name="email" placeholder="Email Address" required value="{{ old('email', $customer->email) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="sr-only" for="phone-{{ $customer->id }}">Phone</label>
                                    <input id="phone-{{ $customer->id }}" type="tel" name="phone" placeholder="+212612345678" pattern="^\+212\d{9}$" inputmode="tel" value="{{ old('phone', $customer->phone) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" title="Moroccan number in international format: +212 followed by 9 digits (e.g. +212612345678)">
                                </div>

                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label class="sr-only" for="address-{{ $customer->id }}">Address</label>
                                    <input id="address-{{ $customer->id }}" type="text" name="address" placeholder="Address" value="{{ old('address', $customer->address) }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div class="sm:col-span-2 lg:col-span-1 flex items-center space-x-2">
                                    <label class="inline-flex items-center">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $customer->is_active) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-blue-600">
                                        <span class="ml-2 text-sm text-gray-700">Active</span>
                                    </label>
                                </div>

                                <div class="sm:col-span-2 lg:col-span-1 flex items-end space-x-2">
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-150">
                                        Update
                                    </button>
                                    <button type="button" onclick="document.getElementById('edit-form-{{ $customer->id }}').classList.add('hidden')" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-lg transition duration-150">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No customers found. Click 'Add New Customer' above to start!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $customers->links() }}
    </div>
@endsection
