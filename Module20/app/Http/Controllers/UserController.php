<?php

namespace App\Http\Controllers;

use App\Helper\JWTtoken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {
        try{
            User::create([
                "firstName" => $request->input('firstName'),
                "lastName" => $request->input('lastName'),
                "email" => $request->input('email'),
                "mobile" => $request->input('mobile'),
                "password" => $request->input('password'),
            ]);

            return response()->json([
                "status" => "Success",
                "message" => "User Registration Successful!"
            ]);
        } catch(Exception $e) {
            return response()->json([
                "status" => "Failed",
                "message" => "User Registration Failed!"
            ]);
        }

    }

    public function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
                     ->where('password', '=', $request->input('password'))
                     ->count();

        if($count == 1)
        {
            $token = JWTtoken::CreateToken($request->input('email'));
            return response()->json([
                "status" => "Success",
                "message" => "User Login successful",
                "token" => $token
            ]);
        }

        else
        {
            return response()->json([
                "status" => "Failed",
                "message" => "Unauthorized"
            ]);
        }
    }

    public function SendOtpCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count = User::where('email',"=",$email)->count();

        if($count == 1)
        {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email','=',$email)->update(['otp' => $otp]);
            return response()->json([
                "status" => "Success",
                "message" => "4 digit otp code has been sent to your mail."
            ]);
        }
        else
        {
            return response()->json([
                "status" => "Failed",
                "message" => "Unauthorized"
            ]);
        }
    }

    public function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email','=', $email)
                     ->where('otp', '=', $otp)
                     ->count();
        if($count == 1)
        {
            User::where('email','=',$email)->update(['otp' => 0]);

            $token = JWTtoken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                "status" => "Success",
                "message" => "Otp verification successful",
                "token" => $token
            ]);
        }
        else
        {
            return response()->json([
                "status" => "Failed",
                "message" => "Unauthorized"
            ]);
        }

    }

    public function ResetPassword(Request $request)
    {
        try
        {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                "status" => "Success",
                "message" => "Password reset successful"
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                "status" => "Failed",
                "message" => "Something Went Wrong"
            ]);
        }

    }

}
