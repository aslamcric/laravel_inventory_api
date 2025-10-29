<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return Purchase::with(['supplier', 'product'])->latest()->get();
    }

    public function store(Request $request)
    {
        $purchase = Purchase::create($request->all());

        // Automatically update product stock
        $product = Product::find($request->product_id);
        $product->stock += $request->quantity;
        $product->save();

        return response()->json(['message' => 'Purchase added successfully', 'purchase' => $purchase]);
    }

    public function show(Purchase $purchase)
    {
        return $purchase->load(['supplier', 'product']);
    }

    public function update(Request $request, Purchase $purchase)
    {
        // If quantity changed, update product stock
        $product = Product::find($purchase->product_id);
        $product->stock -= $purchase->quantity; // subtract old quantity
        $product->save();

        $purchase->update($request->all());

        $newProduct = Product::find($request->product_id);
        $newProduct->stock += $request->quantity; // add new quantity
        $newProduct->save();

        return response()->json(['message' => 'Purchase updated successfully', 'purchase' => $purchase]);
    }

    public function destroy(Purchase $purchase)
    {
        // Reduce stock before deleting
        $product = Product::find($purchase->product_id);
        $product->stock -= $purchase->quantity;
        $product->save();

        $purchase->delete();

        return response()->json(['message' => 'Purchase deleted successfully']);
    }
}
