<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    // Load suppliers for dropdown
    public function index()
    {
        $suppliers = Supplier::select('id', 'name')->get();

        return response()->json([
            'suppliers' => $suppliers,
        ]);
    }

    // Generate purchase report
    public function purchaseReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $supplierId = $request->supplier_id;

        $query = Purchase::with('supplier');

        // Filter by purchase date
        if ($startDate && $endDate) {
            $query->whereBetween('purchase_date', [$startDate, $endDate]);
        }

        // Filter by supplier
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();

        // Totals
        $totalPaid = $purchases->sum('paid_amount');
        $totalUnpaid = $purchases->sum(fn($p) => max($p->total_amount - $p->paid_amount, 0));
        $totalPending = $purchases->sum(fn($p) => max($p->total_amount - $p->paid_amount - $p->discount, 0));

        return response()->json([
            'purchases' => $purchases,
            'total_paid' => $totalPaid,
            'total_unpaid' => $totalUnpaid,
            'total_pending' => $totalPending,
        ]);
    }
}
