<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function createUser(Request $request): JsonResponse
    {
        User::query()->create([
            'name' => 'Henrique Rocha',
            'email' => 'app@login.com',
            'password' => bcrypt('password'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'User created successfully'], Response::HTTP_OK);
    }
}
