<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // Show all purchases with supplier data
    public function allPurchaseIndex(Request $request)
    {
        $query = Purchase::with('suppliers');

        if ($request->search) {
            $query->whereHas('suppliers', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        return response()->json($query->paginate(5));
    }

    // Load supplier & product lists for form
    public function index()
    {
        try {
            $suppliers = Supplier::all();
            $products = Product::all();
            return response()->json(compact('suppliers', 'products'));
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    // Process a new purchase
    public function process(Request $request)
    {
        try {
            $purchase = new Purchase();
            $purchase->supplier_id = $request->supplier['id'];
            $purchase->purchase_date = now();
            $purchase->invoice_no = 'INV-' . time();
            $purchase->total_amount = $request->order_total;
            $purchase->paid_amount = $request->paid_amount ?? $request->order_total;
            $purchase->remark = $request->remark ?? '';
            $purchase->discount = $request->discount;
            $purchase->vat = $request->vat;
            $purchase->status = 1;
            $purchase->save();

            $last_id = $purchase->id;

            foreach ($request->products as $product) {
                // Purchase Detail
                $detail = new PurchaseDetail();
                $detail->purchase_id = $last_id;
                $detail->product_id = $product['item_id'];
                $detail->qty = $product['qty'];
                $detail->price = $product['price'];
                $detail->vat = $request->vat;
                $detail->discount = $product['discount'] ?? 0;
                $detail->save();

                // Update Stock
                $stock = Stock::firstOrCreate(
                    ['product_id' => $product['item_id']],
                    ['qty' => 0]
                );
                $stock->qty += $product['qty'];
                $stock->save();
            }

            return response()->json(["success" => true, "purchase_id" => $last_id]);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    // Show one purchase with details
    public function show($id)
    {
        try {
            $purchase = Purchase::with(['purchase_details', 'suppliers', 'purchase_details.products'])
                ->where("id", $id)
                ->first();

            return response()->json(['purchase' => $purchase]);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }
}
