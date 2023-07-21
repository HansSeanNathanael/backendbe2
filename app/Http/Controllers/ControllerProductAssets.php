<?php

namespace App\Http\Controllers;

use App\Models\ProductAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerProductAssets extends Controller
{
    public function add(Request $request) {
        $validasi = Validator::make($request->post(), [
            "product_id" => ["required"],
            "image" => ["required"]
        ], [
            "product_id.required" => "product_id null",
            "image.required" => "image null",
        ]);
        
        if ($validasi->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validasi->errors()->first()
            ], 422);
        }

        $productID = $request->post("product_id");
        $image = $request->post("image");

        $productAssets = new ProductAssets();
        $productAssets->product_id = $productID;
        $productAssets->image = $image;
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

        $productAssets->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
