<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @group Auth
     * Login
     * 
     * @queryParam email string required O email do usuário.
     * 
     * @queryParam password string required A senha do usuário.
     * 
     * @response 200 {
     *     "token": "1234567890"
     * }
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (Auth::attempt($validator->validated())) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @group Auth
     * Logout
     * 
     * @response 200 {
     *     "message": "Logged out successfully"
     * }
     * 
     * @header Authorization Bearer {token}
     */
    public function logout(Request $request)
    {
        try{
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
