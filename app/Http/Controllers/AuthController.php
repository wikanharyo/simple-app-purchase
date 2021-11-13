<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthRequest;
use App\Http\Requests\CreateRegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(
        CreateRegisterRequest $request
    ) {
        // create a new user
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'result' => false,
                'message' => 'Email already registered',
            ], 400);
        }

        // User created
        return response()->json([
            'result' => true,
            'message' => 'User created successfully',
        ], Response::HTTP_OK);
    }

    public function authenticate(CreateAuthRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        // Validated request
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'result' => false,
                    'message' => 'Invalid login credentials',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'error' => false,
            'token' => $token,
        ]);
    }
}
