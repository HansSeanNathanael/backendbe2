<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ControllerCategories extends Controller
{
    public function all() : JsonResponse {
        $categories = Categories::all();
        $response = [];
        foreach($categories as $category) {
            array_push($response, [
                "id" => $category->id,
                "name" => $category->name
            ]);
        }

        return response()->json($response);
    }

    public function allSortedByFreq() : JsonResponse {
        $categoriesFreq = Products::query()->select("category_id", DB::raw("COUNT(category_id) as frequency"))->groupBy("category_id");
        $categories = Categories::query()
            ->select("categories.*", "freq.frequency AS amount")
            ->joinSub($categoriesFreq, "freq", function($join) {
                $join->on('categories.id', '=', 'freq.category_id');
            })
            ->get();
        $response = [];
        foreach($categories as $category) {
            array_push($response, [
                "id" => $category->id,
                "name" => $category->name,
                "amount" => $category->amount
            ]);
        }

        return response()->json($response);
    }
}
