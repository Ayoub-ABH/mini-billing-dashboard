<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices (Invoices Page).
     */
    public function index(): View
    {
        // Eager load customer data and paginate
        $invoices = Invoice::with('customer')->latest()->paginate(10);
        // Pass customers for the creation dropdown list
        $customers = Customer::latest()->get(['id', 'name', 'email']);

        return view('pages.invoices.index', compact('invoices', 'customers'));
    }

    /**
     * Store a newly created invoice.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:Pending,Paid,Void,Late',
        ]);

        Invoice::create($validated);

        return redirect()->route('invoices.index')->with('success', 'Invoice successfully created!');
    }

    /**
    * Update the specified invoice.
    */
    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number,'.$invoice->id,
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:Pending,Paid,Void,Late',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted.');
    }
}
