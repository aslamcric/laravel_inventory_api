<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OrderDetail::with('product');

        if ($request->search) {
            $query->where('order_id', 'like', "%{$request->search}%");
        }
        return response()->json($query->paginate(8));
    }
}
