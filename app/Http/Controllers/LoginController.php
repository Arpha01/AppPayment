<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');        
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Email belum diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'password belum diisi'
        ]);

        if($validator->fails()) {
            $response = [
                'status' => 'error',
                'message' => 'Validasi error',
                'errors' => $validator->errors(),
                'content' => null
            ];
            
            return response()->json($response, 400);
        }

        $credentials = $request->only(['email', 'password']);

        if(Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('auth_token')->plainTextToken;

            $response = [
                'status' => 'success',
                'message' => 'Login successfully',
                'errors' => null,
                'content' => [
                    'status_code' => 200,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]
            ];

            return response()->json($response,200);
        }

        $response = [
            'status' => 'error',
            'message' => 'Unathorized',
            'errors' => null,
            'content' => null,
        ];

        return response()->json($response, 401);
    }

    public function logout(Request $request) 
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        $response = [
            'status' => 'success',
            'message' => 'Logout successfully',
            'errors' => null,
            'content' => null,
            
        ];

        return response()->json($response, 200);
    }
}
