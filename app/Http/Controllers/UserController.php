<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json(['users' => $users]);
    }

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

       $user = $this->userService->createUser($request->all());

       return  response()->json([
        'user created sucess' => $user
       ],201);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request, string $id)
    {
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

        $user = $this->userService->updateUser($id, $request->all());

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

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
