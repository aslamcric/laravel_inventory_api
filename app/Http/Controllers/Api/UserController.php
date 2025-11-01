<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        return response()->json($query->paginate(4));
    }

    public function destroy($id)
	{
		try {
			$user = User::destroy($id);
			return response()->json(['user' => $user]);
		} catch (\Throwable $th) {
			return response()->json(['error' => $th->getMessage()]);
		}
	}
}
