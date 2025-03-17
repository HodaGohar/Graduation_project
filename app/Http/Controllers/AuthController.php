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
           "email" => "required|string|email|max:225|unique:users",
           "password" => "required|string|min:6"
        ]);

        try {
            // Create a new user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']), // Hash the password
            ]);

            // Respond with success
            return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json(['message' => 'Internal Server Error'], 500);
        }});
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

//     public function login(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required'
//     ]);

//     if (!Auth::attempt($credentials)) {
//         return response()->json(['message' => 'Login failed. Please check your credentials.'], 401);
//     }

//     $user = Auth::user();
//     $token = $user->createToken('auth_token')->plainTextToken;

//     return response()->json(['token' => $token, 'user' => $user]);
// }


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
