<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function Login($credential)
    {
        $token = Auth::attempt($credential);
        return $token;
    }

    public function Register($dataUser)
    {
        $user = $this->user::create([
            'name' => $dataUser['name'],
            'username' => $dataUser['username'],
            'email' => $dataUser['email'],
            'password' => bcrypt($dataUser['password'])
        ]);

        return $user;
    }
}
