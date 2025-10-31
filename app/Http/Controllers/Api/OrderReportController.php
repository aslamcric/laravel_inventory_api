<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderReportController extends Controller
{
    public function index()
    {
        $customers = Customer::select('id', 'name', 'address')->get();

        return response()->json([
            'customers' => $customers,
        ]);
    }

    /**
     * Generate Order Report
     */
    public function orderReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $customerId = $request->customer_id;

        $query = Order::with(['customers']);

        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        // Calculate totals
        $totalPaid = $orders->sum('paid_amount');
        $totalUnpaid = $orders->sum(function ($order) {
            return max($order->order_total - $order->paid_amount, 0);
        });

        return response()->json([
            'orders' => $orders,
            'total_paid' => $totalPaid,
            'total_unpaid' => $totalUnpaid,
        ]);
    }
}
