<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers (Customer Page).
     */
    public function index(): View
    {
        // Use withCount to optimize loading the number of invoices per customer
        $customers = Customer::withCount('invoices')->latest()->paginate(10);
        return view('pages.customers.index', compact('customers'));
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request): RedirectResponse
    {
        // Best practice: Use a dedicated Form Request for validation in production
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer successfully added!');
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,'.$customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)->with('success', 'Customer updated successfully.');
    }

    /**
     * Display the specified customer and their invoices (The key feature requested).
     * Uses Route Model Binding (Customer $customer) for clean dependency injection.
     */
    public function show(Customer $customer): View
    {
        // Eager load and order invoices
        $customer->load(['invoices' => function($query) {
            $query->latest('due_date');
        }]);

        return view('pages.customers.show', compact('customer'));
    }

    /**
     * Remove the specified customer and cascade delete invoices (via migration setting).
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer and all associated invoices deleted.');
    }
}
