<?php

namespace App\Http\Controllers\Auth;

use App\helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Mail\otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
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
    public function OtpPage()
    {
        return view('admin.login.auth-otp');
    }
    public function resetPage(){
        return view('admin.login.resetpassword');
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
            ]);
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
            ],200)->cookie('token', $token, 60);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Password or email is wrong!"
            ]);
        }
    }

    public function logOut(Request $request){
        if ($request->hasCookie('token')) {
            return response()->json([
                "status" => "success",
                "message" => "Logged out successfully!"
            ],200)->withCookie(Cookie::forget('token'));
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Token not found in cookie!"
            ]);
        }
    }

    public function sendOtp(Request $req){
        $validation = Validator::make($req->all(), [
            'email' => "required|email",
        ]);
        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ],200);
        }
        //send the otp in mail
        $user = User::where('email',$req->email)->first();
        if($user){
            $otp = rand(10000, 99999);
            if (Mail::to($user->email)->send(new otp($otp))){
                $user->update([
                    'otp' => $otp
                ]);
                return response()->json([
                    "status" => "success",
                    "message" => "OTP send successfully!"
                ],200);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => "Something went wrong!"
                ]);
            }
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Email not registered!"
            ]);
        };
    }


    public function verifyOtp(Request $req){
        $validation = Validator::make($req->all(), [
            'otp' => "required",
        ]);
        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ]);
        }
        $user = User::where('email', $req->email)->where('otp',$req->otp)->first();
        if($user){
            $user->update([
                'otp' => 0
            ]);
            $token = JWTToken::CreateToke($user->id,$user->email,10);
            return response()->json([
                "status" => "success",
                "message" => "OTP send successfully!",
                "token" => $token
            ])->cookie('token', $token, 10);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Otp And Email Not Match!"
            ]);
        }
    }

    public function resetPassword(Request $req){
        $validation = Validator::make($req->all(), [
            "password" => "required|min:6",
        ]);
        if($validation->fails()){
            return response()->json([
                "status" => "failed",
                "message" => $validation->errors()
            ],200);
        }

        $user = User::where('email',$req->header('email'))->update([
            "password" => $req->password
        ]);

        if($user){
            return response()->json([
                "status" => "success",
                "message" => "Password reset successfully!"
            ],200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Something went wrong!"
            ]);
        }
    }
}
