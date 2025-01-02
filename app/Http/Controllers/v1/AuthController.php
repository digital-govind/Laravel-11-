<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Response as StatusCodeResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use App\Models\User;


class AuthController extends Controller
{
    //
    public function register(Request $request){
        
        $validator = Validator::make($request->all(), [
            //'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => false, 'errors' => $validator->errors()],StatusCodeResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $auth_key = Str::random(60);

        $user = User::create([
            'auth_key' => $auth_key,
          //  'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_logged_in' => 1
        ]);

        

        // // Store the token in Redis with a TTL (Time-To-Live)
        // Redis::set('authKey:' . $token, $user->id);
        // Redis::expire('authKey:' . $token, 3600); // Token expires in 1 hour

        Redis::set(getRedisKey('auth', $auth_key) , $user->id, 'EX', 2592000);

       
        Redis::set(getRedisKey('user', $user->id), json_encode($user));

        return Response::json([
            'success' => true,
            'message' => "Account created successfully",
            'data' => [
                'user' => $user,
            ],
            
            'token' => $auth_key,
        ], StatusCodeResponse::HTTP_CREATED);

        
    }

    public function login(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return Response::json(['success' => false, 'error' => 'Invalid credentials'], StatusCodeResponse::HTTP_UNAUTHORIZED);
        }

        $auth_key = Str::random(60);
        
        Redis::set(getRedisKey('auth', $auth_key) , $user->id, 'EX', 2592000);

       
        Redis::set(getRedisKey('user', $user->id), json_encode($user));
        
        return Response::json([
            'success' => true,
            'message' => "Account Login successfull",
            'data' => [
                'user' => $user,
            ],
            
            'token' => $auth_key,
        ], StatusCodeResponse::HTTP_OK);
    } 

    public function fetchUser(Request $request)
    {
        $authKey = $request->header('AuthKey');

        if (!$authKey) {
            
            return Response::json([
                'success' => false, 
                'error' => 'AuthKey is required.'], 
                StatusCodeResponse::HTTP_BAD_REQUEST);
        }

        $user = User::where('auth_key', $authKey)->first();

        if (!$user) {
            
            return Response::json([
                'status_code' => StatusCodeResponse::HTTP_NOT_FOUND,
                'success' => false, 
                'error' => 'User not found'], 
                StatusCodeResponse::HTTP_NOT_FOUND);
        }


       
        return Response::json([
            'success' => true,
            'data' => [
                'user' => $user,
            ]
            
        ], StatusCodeResponse::HTTP_OK);
    }

}
