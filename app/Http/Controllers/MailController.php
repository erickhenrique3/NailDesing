<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        User::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'verification_code' => $code,
                'verified' => false
            ]
        );
    
    
        Mail::to($request->email)->send(new VerificationCodeMail($request->name, $code));
    
        return response()->json([
            'message' => 'Código enviado com sucesso!',
        ]);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        if ($user->verification_code != $request->code) {
            return response()->json(['message' => 'Código inválido ou expirado.'], 401);
        }

        $user->update(['verified' => true, 'email_verified_at' => now()]);

        $user->update(['verification_code' => null]);

        return response()->json(['message' => 'Código verificado com sucesso!', 'user' => $user]);
    }
}
