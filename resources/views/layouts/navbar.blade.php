<!-- Navigation Bar -->
    <nav class="bg-white shadow-md border-b border-gray-100 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-extrabold text-indigo-600">MiniBill.</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        @php $currentRoute = Route::currentRouteName(); @endphp
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm transition-colors {{ $currentRoute == 'dashboard' ? 'active-link' : 'inactive-link' }}">Dashboard</a>
                        <a href="{{ route('customers.index') }}" class="inline-flex items-center px-1 pt-1 text-sm transition-colors {{ str_starts_with($currentRoute, 'customers') ? 'active-link' : 'inactive-link' }}">Customers</a>
                        <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-1 pt-1 text-sm transition-colors {{ str_starts_with($currentRoute, 'invoices') ? 'active-link' : 'inactive-link' }}">Invoices</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
