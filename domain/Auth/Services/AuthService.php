<?php

namespace Domain\Auth\Services;

use App\Models\User;
use Domain\Auth\Contracts\AuthContract;
use Domain\Auth\DTOs\LoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService implements AuthContract
{
  public function exec(LoginDTO $input)
  {
    
    $credentials = [
        'email'     => $input->email,
        'password'  => $input->password,
    ];

    $user = User::where("email", $credentials['email'])->first();

    if (!Hash::check($credentials['password'], $user->password)) {
        return [
            'status' => false,
            'message' => 'Invalid credentials',
        ];
    }

    $token = $user->createToken("myToken")->accessToken;

    return [
        'status' => true,
        'token' => $token,
    ];
  }
}