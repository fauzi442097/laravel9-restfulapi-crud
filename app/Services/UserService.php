<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use App\Traits\StringResponseError;


class UserService
{
    protected $userRepository;
    use StringResponseError;

    public function __construct(UserInterface $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function Login($credential)
    {
        $token = $this->userRepository->Login($credential);

        if (!$token) {
            $messageError = $this->makeErrorMessage('Username atau password salah', 'Pastikan bahwa username atau password benar');
            throw new ServiceException($messageError, Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();
        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 // 1 Hour
        ];

        return $data;
    }

    public function Register($arrRequest)
    {

        $dataUser = [
            'name' => $arrRequest['name'],
            'username' => $arrRequest['username'],
            'email' => $arrRequest['email'],
            'password' => bcrypt($arrRequest['password']),
        ];

        $user =  $this->userRepository->Register($dataUser);
        $token = Auth::login($user);

        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 // 1 Hour
        ];

        return $data;
    }
}
