<?php

namespace app\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService
{
  public function attemptLogin($credentials)
  {
    $user = User::where("email", $credentials['email'])->first();
    // dd($user->password);

      if (!Hash::check($credentials['password'], $user->password)) {
          return [
              'status' => false,
              'message' => 'Invalid credentials',
          ];
      }

    //   dd($user);
      $token = $user->createToken("myToken")->accessToken;

      return [
          'status' => true,
          'token' => $token,
      ];
  }
}