<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class SupplierController extends Controller
{
	public function index(Request $request)
	{
		$query = Supplier::query();

		if ($request->search) {
			$query->where('name', 'like', "%{$request->search}%");
		}
		return response()->json($query->paginate(4));
	}

	public function store(Request $request)
	{
		try {
			$supplier = new Supplier;
			$supplier->name = $request->name;
			$supplier->phone = $request->phone;
			$supplier->company = $request->company;
			$supplier->email = $request->email;
			$supplier->address = $request->address;
			date_default_timezone_set("Asia/Dhaka");
			$supplier->created_at = date('Y-m-d H:i:s');
			date_default_timezone_set("Asia/Dhaka");
			$supplier->updated_at = date('Y-m-d H:i:s');

			$supplier->save();

			return response()->json(['supplier' => $supplier]);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()]);
		}
	}

	public function show($id)
	{
		try {
			$supplier = Supplier::find($id);

			if (!$supplier) {
				return response()->json(['message' => 'Supplier not found'], 404);
			}

			return response()->json(['supplier' => $supplier]);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()]);
		}
	}

	public function update(Request $request, string $id)
	{
		try {
			$supplier = Supplier::find($id);

			if (!$supplier) {
				return response()->json(['message' => 'Supplier not found'], 404);
			}

			$supplier->name = $request->name;
			$supplier->phone = $request->phone;
			$supplier->company = $request->company;
			$supplier->email = $request->email;
			$supplier->address = $request->address;

			$supplier->save();

			return response()->json(['supplier' => $supplier]);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()], 500);
		}
	}

	public function destroy($id)
	{
		try {
			$supplier = Supplier::destroy($id);
			return response()->json(['supplier' => $supplier]);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()]);
		}
	}
}
