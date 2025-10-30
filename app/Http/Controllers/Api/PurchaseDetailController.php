<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseDetail::with('product');

        if ($request->search) {
            $query->where('purchase_id', 'like', "%{$request->search}%");
        }

        return response()->json($query->paginate(8));
    }
}



// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\PurchaseDetail;
// use App\Models\Product;
// use Illuminate\Http\Request;

// class PurchaseDetailController extends Controller
// {
//     // List purchase details with pagination and search
//     public function index()
//     {
//         $query = PurchaseDetail::with('product', 'purchase');

//         if (request()->has('search') && request('search') != '') {
//             $query->where('purchase_id', request('search'));
//         }

//         $details = $query->latest()->paginate(8)->withQueryString();

//         return response()->json($details);
//     }

//     // Store a new purchase detail and update product stock
//     public function store(Request $request)
//     {
//         $request->validate([
//             'purchase_id' => 'required|exists:purchases,id',
//             'product_id'  => 'required|exists:products,id',
//             'quantity'    => 'required|integer|min:1',
//             'price'       => 'required|numeric|min:0',
//             'discount'    => 'nullable|numeric|min:0',
//         ]);

//         $detail = PurchaseDetail::create($request->all());

//         $product = Product::find($request->product_id);
//         $product->stock += $request->quantity;
//         $product->save();

//         return response()->json([
//             'message' => 'Purchase detail added successfully',
//             'detail'  => $detail,
//         ]);
//     }

//     // Show a single purchase detail
//     public function show(PurchaseDetail $purchaseDetail)
//     {
//         return $purchaseDetail->load('product', 'purchase');
//     }

//     // Update purchase detail and adjust stock
//     public function update(Request $request, PurchaseDetail $purchaseDetail)
//     {
//         $request->validate([
//             'product_id' => 'required|exists:products,id',
//             'quantity'   => 'required|integer|min:1',
//             'price'      => 'required|numeric|min:0',
//             'discount'   => 'nullable|numeric|min:0',
//         ]);

//         $oldProduct = Product::find($purchaseDetail->product_id);
//         $oldProduct->stock -= $purchaseDetail->quantity;
//         $oldProduct->save();

//         $purchaseDetail->update($request->all());

//         $newProduct = Product::find($request->product_id);
//         $newProduct->stock += $request->quantity;
//         $newProduct->save();

//         return response()->json([
//             'message' => 'Purchase detail updated successfully',
//             'detail'  => $purchaseDetail,
//         ]);
//     }

//     // Delete purchase detail and reduce stock
//     public function destroy(PurchaseDetail $purchaseDetail)
//     {
//         $product = Product::find($purchaseDetail->product_id);
//         $product->stock -= $purchaseDetail->quantity;
//         $product->save();

//         $purchaseDetail->delete();

//         return response()->json([
//             'message' => 'Purchase detail deleted successfully',
//         ]);
//     }
// }
