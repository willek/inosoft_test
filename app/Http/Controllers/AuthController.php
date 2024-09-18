<?php

namespace App\Http\Controllers;


class AuthController extends Controller
{
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->unauthorized();
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->ok(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->ok(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->ok([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
