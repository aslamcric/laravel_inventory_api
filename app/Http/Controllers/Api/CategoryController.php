<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
	public function index(Request $request)
	{
		$query = Category::query();

		if ($request->search) {
			$query->where('name', 'like', "%{$request->search}%");
		}
		return response()->json($query->paginate(4));
	}

	public function store(Request $request)
	{
		try {
			$category = new Category;
			$category->name = $request->name;
			$category->description = $request->description;
			date_default_timezone_set("Asia/Dhaka");
			$now = date('Y-m-d H:i:s');
			$category->created_at = $now;
			$category->updated_at = $now;

			$category->save();

			return response()->json(["category" => $category]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}


	public function show($id)
	{
		try {
			$category = Category::find($id);

			if (!$category) {
				$category = "Data Not Found";
			}

			return response()->json(['category' => $category]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}


	public function update(Request $request, Category $category, string $id)
	{
		try {
			$category = Category::find($id);
			$category->name = $request->name;
			$category->description = $request->description;
			date_default_timezone_set("Asia/Dhaka");
			$category->created_at = date('Y-m-d H:i:s');
			date_default_timezone_set("Asia/Dhaka");
			$category->updated_at = date('Y-m-d H:i:s');

			$category->save();

			return response()->json(['category' => $category]);
		} catch (\Throwable $th) {
			return response()->json(["error" => $th->getMessage()]);
		}
	}

	public function destroy(Category $category, string $id)
	{
		try {
			$category = Category::destroy($id);
			return response()->json(["category" => $category]);
		} catch (\Throwable $th) {
			return response()->json(["category" => $th]);
		}
	}
}
