<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
	public function index(Request $request)
	{
		// $query = Product::query();
		$query = Product::with('category');

		if ($request->search) {
			$query->where('name', 'like', "%{$request->search}%");
		}
		return response()->json($query->paginate(3));
	}

	// Dropdown Category
	public function dropCategory(Request $request)
	{
		$query = Category::all();

		return response()->json($query);
	}

	public function store(Request $request)
	{
		try {
			$product = new Product;
			$product->category_id = $request->category_id;
			$product->name = $request->name;
			$product->price = $request->price;
			$product->stock = $request->stock;
			$product->description = $request->description;
			date_default_timezone_set("Asia/Dhaka");
			$product->created_at = date('Y-m-d H:i:s');
			date_default_timezone_set("Asia/Dhaka");
			$product->updated_at = date('Y-m-d H:i:s');

			$product->save();

			return response()->json(["product" => $product]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function show(string $id)
	{
		try {
			$product = Product::find($id);

			if (!$product) {
				$product = "Data Not Found";
			}

			return response()->json(['product' => $product]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function update(Request $request, string $id)
	{
		try {
			$product = Product::find($id);

			if (!$product) {
				return response()->json(["message" => "product not Found"]);
			}

			$product->category_id = $request->category_id;
			$product->name = $request->name;
			$product->price = $request->price;
			$product->stock = $request->stock;
			$product->description = $request->description;
			
			date_default_timezone_set("Asia/Dhaka");
			$product->updated_at = date('Y-m-d H:i:s');

			$product->save();

			return response()->json(["product" => $product]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function destroy(string $id)
	{
		try {
			$product = Product::destroy($id);
			return response()->json(["product" => $product]);
		} catch (\Throwable $th) {
			return response()->json(["product" => $th]);
		}
	}
}
