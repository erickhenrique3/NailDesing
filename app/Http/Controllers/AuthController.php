<?php

namespace App\Http\Controllers;

use Domain\Auth\Contracts\AuthContract;
use Domain\Auth\DTOs\LoginDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(protected readonly AuthContract $authContract)
    {}

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $response = $this->authContract->exec(new LoginDTO (
            email:  $request->email,
            password: $request->password
        ));
       

        if (!$response['status']) {
            return response()->json(['error' => $response['message']], 401);
        }

        return response()->json(['token' => $response]);
    }
}
