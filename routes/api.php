<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/token/create', function (Request $request) {
    if (!Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
        return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
    }

    return response()->json(['token' => auth()->user()->createToken(request('email'))->plainTextToken]);
});

Route::post('/user/create', [AuthController::class, 'createUser']);