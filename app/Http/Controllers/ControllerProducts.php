<?php

namespace App\Http\Controllers;

use App\Models\ProductAssets;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerProducts extends Controller
{
    
    public function allWithAssets() : JsonResponse {

        $products = Products::all();
        $assets = ProductAssets::all();

        $assetArray = [];
        foreach($assets as $asset) {
            if (! isset($assetArray[$asset->product_id])) {
                $assetArray[$asset->product_id] = [];
            }
            array_push($assetArray[$asset->product_id], [
                "asset_id" => $asset->id,
                "image" => $asset->image
                ]
            );
        }
        
        $response = [];
        foreach($products as $product) {
            array_push($response, [
                "id" => $product->id,
                "category_id" => $product->category_id,
                "name" => $product->name,
                "slug" => $product->slug,
                "price" => $product->price,
                "assets" => isset($assetArray[$product->id]) ? $assetArray[$product->id] : [],
            ]);
        }

        return response()->json($response);
    }

    public function allFromMostExpensive() : JsonResponse {
        $products = Products::query()->orderBy("price", "desc")->get();
        $response = [];
        foreach($products as $product) {
            array_push($response, [
                "id" => $product->id,
                "category_id" => $product->category_id,
                "name" => $product->name,
                "slug" => $product->slug,
                "price" => $product->price,
            ]);
        }
        return response()->json($response);
    }

    public function add(Request $request) {
        $validasi = Validator::make($request->post(), [
            "category_id" => ["required"],
            "name" => ["required"],
            "slug" => ["required"],
            "price" => ["required", "numeric"],
            "assets" => ["required", "array"],
            "assets.*" => ["string"]
        ], [
            "category_id.required" => "category_id null",
            "name.required" => "name null",
            "slug.required" => "slug null",
            "price.required" => "price null",
            "price.numeric" => "price must numeric",
            "assets.required" => "assets null",
            "assets.array" => "assets must array",
            "assets.*.string" => "assets must array of string"
        ]);
        
        if ($validasi->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validasi->errors()->first()
            ], 422);
        }

        $categoryID = $request->post("category_id");
        $name = $request->post("name");
        $slug = $request->post("slug");
        $price = $request->post("price");

        $product = new Products();
        $product->category_id = $categoryID;
        $product->name = $name;
        $product->slug = $slug;
        $product->price = $price;
        $product->save();

        $assets = $request->post("assets");
        foreach($assets as $asset) {
            $newAsset = new ProductAssets();
            $newAsset->product_id = $product->id;
            $newAsset->image = $asset;
            $newAsset->save();
        }

        return response()->json([
            "status" => "success"
        ], 200);
    }

    public function edit(Request $request) {

        $validasi = Validator::make($request->post(), [
            "id" => ["required"],
            "category_id" => ["required"],
            "name" => ["required"],
            "slug" => ["required"],
            "price" => ["required", "numeric"]
        ], [
            "id.required" => "id null",
            "category_id.required" => "category_id null",
            "name.required" => "name null",
            "slug.required" => "slug null",
            "price.required" => "price null",
            "price.numeric" => "price must numeric"
        ]);
        
        if ($validasi->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validasi->errors()->first()
            ], 422);
        }

        $id = $request->post("id");
        $categoryID = $request->post("category_id");
        $name = $request->post("name");
        $slug = $request->post("slug");
        $price = $request->post("price");

        $product = Products::query()->where("id", "=", $id)->first();
        if ($product == null) {
            return response()->json([
                "status" => "error",
                "message" => "product didn't exist"
            ], 422);
        }

        $product->category_id = $categoryID;
        $product->name = $name;
        $product->slug = $slug;
        $product->price = $price;
        $product->save();

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

        $product = Products::query()->where("id", "=", $id)->first();
        if ($product == null) {
            return response()->json([
                "status" => "error",
                "message" => "product didn't exist"
            ], 422);
        }

        $product->delete();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
