<?php

namespace App\Http\Controllers\Auth;

use App\helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function logInpage()
    {
        return view('admin.login.auth-login');
    }
    public function registerPage()
    {
        return view('admin.login.auth-register');
    }
    public function recoverPage()
    {
        return view('admin.login.auth-recoverpw');
    }
    public function Registation(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'first_name' => "required",
            'last_name' => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
        ]);

        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ],400);
        }

        $user = User::create([
            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'email' => $req->email,
            'password' => $req->password
        ]);

        if($user){
            return response()->json([
                "status" => "success",
                "message" => "Register successfully!"
            ],200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong Registation Failed!"
            ]);
        }

    }

    public function logIn(Request $req){
        $validation = Validator::make($req->all(), [
            'email' => "required|email",
            'password' => "required|min:6"
        ]);
        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ]);
        }
        $user = User::where('email',$req->email)->where('password',$req->password)->first();
        if($user){
            $token = JWTToken::CreateToke($user->id,$user->email);
            return response()->json([
                'status' => "success",
                "message" => "Login successfully!",
                'token' => $token
            ])->cookie($token);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Login Failed!"
            ]);
        }
    }

    public function logOut(){
        if (cookie()->forget('token')) {
            return response()->json([
                "status" => "success",
                "message" => "Logged out successfully!"
            ],200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Token not found in cookie!"
            ]);
        }
    }
}
