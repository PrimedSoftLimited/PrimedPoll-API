<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;


class ResetPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function resetPassword(Request $request)
    {

        $attributes = $this->validate($request, [
            'verify_code' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // $time =  time();
        // $created_time = date('h:i A â€” Y-m-d', $time + 3600);

        // $checkVerificationCode = User::where('verify_code', $request->input('verify_code'))->exists();

        // if ($checkVerificationCode) {

        //     //Check table users if verification code exists
        //     $userVerificationCode = User::where('verify_code', $request->input('verify_code'))->first();

        //     //Generatate a token for the password recvery process
        //     $generateVerifyToken = Str::random(60);

        //     $verify_token = hash('sha256', $generateVerifyToken);

        //     $userVerificationCode->verify_code = $verify_token;

        //     $userVerificationCode->password = Hash::make($request->input('password'));

        //     $userVerificationCode->save();

    //         //Return Json response if successful
    //         return response()->json(['data' => ['success' => true, 'message' => 'New password Updated']], 200);
    //     } else {
    //         //Return Json response if unsuccessful
    //         return response()->json(['data' => ['error' => true, 'message' => 'Update Already Done or Invalid code']], 401);
    //     }
}
}
