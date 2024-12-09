<?php

namespace App\Http\Controllers;

use App\Events\UserLogedd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

  

    public function index()
    {
        $userAll = User::all();

        return response()->json([
            'users' => $userAll
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       $validateData = Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'phone' => 'required|numeric|unique:users',
        'password' => 'required|min:6',
       ]);

       if($validateData->fails()){
        return response()->json([
            'error' => $validateData->errors()
        ],422);
       }

       $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => $request->role,
        'password' => $request->password
       ]);


       return  response()->json([
        'user created sucess' => $user
       ],201);
    }

    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
			"email" => "required|email",
			"password" => "required",
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'message' => 'Validation failed',
				'errors' => $validator->errors()
			], 422);
		}

		$user = User::where("email", $request->email)->first();

		if (!empty($user)) {
			if (Hash::check($request->password, $user->password)) {
				$token = $user->createToken("myToken")->accessToken;
                broadcast(new UserLogedd($user));
				return response()->json([
					"status" => true,
					"message" => "Login sucessfull",
					"token" => $token
				]);
			}
		}
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|unique:users,phone',
            'password' => 'required|string|max:6'
        ]);

        if($validatedData->fails()){
            return response()->json([
                'error' => $validatedData->errors()
            ],422);
        }

        $user->update($validatedData->validate());

        return response()->json([
            'status' => true,
            'message' => 'Informações atualizadas com sucesso',
            'data' => $user
        ]);
    }

    public function profile()
	{
		$userData = Auth::user();
		return response()->json([
			"status" => true,
			"message" => "profile information",
			"data" => $userData
		]);
	}

    public function logout(Request $request)
	{
		$request->user()->token()->revoke();

		return response()->json([
			"status" => true,
			"message" => "Usuário deslogado com sucesso"
		]);
	}
}
