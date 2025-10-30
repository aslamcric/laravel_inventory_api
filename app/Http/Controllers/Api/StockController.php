<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the stock data.
     */
    public function index(Request $request)
    {
        // ✅ Query to join products with stock table and sum qty
        $query = DB::table('stocks as s')
            ->join('products as p', 'p.id', '=', 's.product_id')
            ->select('p.id', 'p.name', DB::raw('SUM(s.qty) as qty'))
            ->groupBy('p.id', 'p.name');

        // ✅ Search by product name (if available)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('p.name', 'like', "%{$search}%");
        }

        // ✅ Paginate (8 per page)
        $stocks = $query->paginate(8)->withQueryString();

        return response()->json($stocks);
    }
}
