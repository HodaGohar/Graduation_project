<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HandlesApiExceptions;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HandlesApiExceptions;
    public function register(Request $request){
        return $this->HandleApiExceptions(function() use ($request){
        $validatedData = $request->validate([
           "name" => "required|string|max:225",
           "email" => "required|email|unique:users|max:225",
           "password" => "required|string|min:6"
        ]);

        $user = User::create([
            "name" => $validatedData["name"],
            "email" => $validatedData["email"],
            "password"=> bcrypt($validatedData["password"]),
        ]);
        return $this->generateTokenResponse($user , "Account created successfully" ,201);
        });
    }

    public function login(Request $request){
        return $this->HandleApiExceptions(function() use ($request){
            $validateData = $request->validate([
               "email" => "required|email",
               "password" => "required|string"
            ]);
            $user = User::where('email' , $validateData['email'])->first();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            if (!Hash::check($validateData['password'], $user->password)) {
                return response()->json(['message' => 'Incorrect password'], 401);
            }

           return $this->generateTokenResponse($user , 'Login successful');
        });
    }

    public function logout(Request $request){
        return $this->HandleApiExceptions(function() use ($request){
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logout successful'], 200);
        });
    }

    
    private function generateTokenResponse(User $user , $message ,$statusCode = 200){

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'message'=> $message ,
            'user' => $user ,
            'token' => $token
        ],$statusCode);
    }

}
