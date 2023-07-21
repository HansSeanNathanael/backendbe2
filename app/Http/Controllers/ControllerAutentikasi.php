<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControllerAutentikasi extends Controller
{
    public function login(Request $request) : JsonResponse {
        $name = $request->post("name");
        $password = $request->post("password");

        if ($name === null) {
            return response()->json([
                "error" => "name null"
            ], 422);
        }
        if ($password === null) {
            return response()->json([
                "error" => "password null"
            ], 422);
        }

        if (! Auth::attempt([
            "name" => $name,
            "password" => $password
        ])) {
            return response()->json([
                "error" => "unauthorized"
            ], 401);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            "token" => $token
        ], 200);
    }
}
