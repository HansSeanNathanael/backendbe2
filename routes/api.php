<?php

use App\Http\Controllers\ControllerAutentikasi;
use App\Http\Controllers\ControllerCategories;
use App\Http\Controllers\ControllerProductAssets;
use App\Http\Controllers\ControllerProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/categories/all", [ControllerCategories::class, "all"]);
Route::get("/categories/all-sorted-freq", [ControllerCategories::class, "allSortedByFreq"]);

Route::get("/products/all-with-assets", [ControllerProducts::class, "allWithAssets"]);
Route::get("/products/all-from-expensive", [ControllerProducts::class, "allFromMostExpensive"]);

Route::post("/login", [ControllerAutentikasi::class, "login"]);

Route::middleware("auth:sanctum")->group(function() {
    Route::post("/products", [ControllerProducts::class, "add"]);
    Route::post("/products/edit", [ControllerProducts::class, "edit"]);
    Route::delete("/products/{id}", [ControllerProducts::class, "delete"]);


    Route::post("/assets", [ControllerProductAssets::class, "add"]);
    Route::delete("/assets/{id}", [ControllerProductAssets::class, "delete"]);
});

Route::any("/unauthorized", function() {
    return response()->json([
        "status" => "error",
        "message" => "unauthorized"
    ], 401);
})->name("unauthorized");
