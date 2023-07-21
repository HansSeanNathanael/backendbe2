<?php

namespace App\Http\Controllers;

use App\Models\ProductAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ControllerProductAssets extends Controller
{
    public function add(Request $request) {
        $productID = $request->post("product_id");
        if ($productID === null) {
            return response()->json([
                "status" => "error",
                "message" => "product_id null"
            ], 422);
        }

        $image = $request->file("image");
        if ($image === null) {
            return response()->json([
                "status" => "error",
                "message" => "image null"
            ], 422);
        }

        $image->storeAs("public", $image->getClientOriginalName());
        
        $productAssets = new ProductAssets();
        $productAssets->product_id = $productID;
        $productAssets->image = $image->getClientOriginalName();
        $productAssets->save();

        return response()->json([
            "status" => "success"
        ], 200);
    }


    public function delete(Request $request, $id) {
        if ($id === null) {
            return response()->json([
                "status" => "error",
                "message" => "id null"
            ], 422);
        }

        $productAssets = ProductAssets::query()->where("id", "=", $id)->first();
        if ($productAssets == null) {
            return response()->json([
                "status" => "error",
                "message" => "asset didn't exist"
            ], 422);
        }
        
        Storage::delete("public/".$productAssets->image);

        $productAssets->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
