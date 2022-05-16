<?php

namespace App\Interfaces;

interface UserInterface
{
    public function Login($credential);
    public function Register($dataUser);
}
