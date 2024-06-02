<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Session;

class AuthController extends Controller
{
    public function loginPage() {
       return view('login'); 
    }
    public function registerPage(Request $request) {
      
        return view('register'); 
     }
    public function loginProcess(Request $request) {
        $request->session()->forget('token');

        $request->session()->put('token', $request->token);
   return redirect(url('frontend-products'));
     }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
       $token = JWTAuth::fromUser($user);
        return response()->json(compact('user'));
    }
//login api function
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $credentials = $request->only('email', 'password');
        //login attempt using jwt
        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json(['error'=>'Unauthorised'], 401);

        }
        
        return response()->json(compact('token'));

     
    }
    public function logout()
    {
        // Get the current user
        $user = Auth::user();
    
        // Invalidate the user's token (optional, depends on your implementation)
        JWTAuth::invalidate(JWTAuth::getToken());
    
        // Other logout logic (e.g., clear any session data)
    
        // Return a response indicating successful logout
        return response()->json(['message' => 'Successfully logged out']);
    }
}
