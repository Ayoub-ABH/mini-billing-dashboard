<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the main statistics dashboard view.
     */
    public function index(): View
    {
        // Calculate key metrics using Eloquent aggregates
        $stats = [
            'total_customers' => Customer::count(),
            'total_invoices' => Invoice::count(),
            'pending_revenue' => Invoice::where('status', 'Pending')->sum('amount'),
            'collected_revenue' => Invoice::where('status', 'Paid')->sum('amount'),
        ];

        // Fetch recent activity using eager loading (best practice)
        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.dashboard', compact('stats', 'recentInvoices'));
    }
}
