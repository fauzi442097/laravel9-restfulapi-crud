<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['username', 'password']);
        $token = Auth::attempt($credentials);

        if (!$token) {
            return $this->responseError(Response::HTTP_UNAUTHORIZED, 'Username atau Password salah', 'Pastikan bahwa username atau password benar');
        }

        $user = auth()->user();
        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 // 1 Hour
        ];

        return $this->responseSuccess($data);
    }

    public function register(RegisterRequest $request)
    {
        $arrRequest = $request->all();

        // Store
        $user = User::create([
            'name' => $arrRequest['name'],
            'username' => $arrRequest['username'],
            'email' => $arrRequest['email'],
            'password' => bcrypt($arrRequest['password']),
        ]);

        $token = Auth::login($user);
        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 // 1 Hour
        ];
        return $this->responseSuccess($data);
    }

    public function logout()
    {
        Auth::logout();
        return $this->responseSuccess();
    }

    public function refresh()
    {
        $data = [
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ];
        return $this->responseSuccess($data);
    }
}
