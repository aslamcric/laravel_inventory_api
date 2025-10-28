<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class CustomerController extends Controller
{
	public function index(Request $request)
	{
		$query = Customer::query();

		if ($request->search) {
			$query->where('name', 'like', "%{$request->search}%");
		}
		return response()->json($query->paginate(4));
	}

	public function store(Request $request)
	{
		try {
			$customer = new Customer;
			$customer->name = $request->name;
			$customer->phone = $request->phone;
			$customer->email = $request->email;
			$customer->address = $request->address;
			date_default_timezone_set("Asia/Dhaka");
			$customer->created_at = date('Y-m-d H:i:s');
			date_default_timezone_set("Asia/Dhaka");
			$customer->updated_at = date('Y-m-d H:i:s');

			$customer->save();

			return response()->json(["customer" => $customer]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function show($id)
	{
		try {
			$customer = Customer::find($id);

			if (!$customer) {
				$customer = "Data Not Found";
			}

			return response()->json(['customer' => $customer]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function update(Request $request, Customer $customer, string $id)
	{
		try {

			$customer = Customer::find($id);

			if (!$customer) {
				return response()->json(["message" => "Customer not found"], 404);
			}

			$customer->name = $request->name;
			$customer->phone = $request->phone;
			$customer->email = $request->email;
			$customer->address = $request->address;
			date_default_timezone_set("Asia/Dhaka");
			$customer->created_at = date('Y-m-d H:i:s');
			date_default_timezone_set("Asia/Dhaka");
			$customer->updated_at = date('Y-m-d H:i:s');

			$customer->save();

			return response()->json(["customer" => $customer]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function destroy(Customer $customer, string $id)
	{
		try {
			$customer = Customer::destroy($id);
			return response()->json(["customer" => $customer]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}
}
