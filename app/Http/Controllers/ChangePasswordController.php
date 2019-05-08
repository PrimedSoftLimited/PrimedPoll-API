<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\NewPassword;

use App\User;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function updatepassword(Request $request)
    {

    // Do a validation for the input
        $this->validate($request, [
        	'verifycode' => 'required|max:6|min:5',
        	'password' => 'required|confirmed',
        ]);

        // changed request type from query to input & added password connfirmation to validation
        $verifycode = $request->input('verifycode');
        $newPassword = $request->input('newpassword');

       $checkverifyemail = User::where('verifycode', $verifycode)->exists();

       if ($checkverifyemail == null)
       {
        return response()->json(['data' =>['success' => false, 'message' => 'Verification code is invalid']], 401);
       } else {
        //start temporay transaction
        DB::beginTransaction();
        $userData = User::where('verifycode', $verifycode)->first();
        try{
            $userData->password = Hash::make($newPassword);
            // Mail::to($VerifyEmail->email)->send(new NewPassword($VerifyEmail));
            $userData->save();

            //if operation was successful save changes to database
            DB::commit();
            return response()->json(['data' => ['success' => true, 'message' => "Your password has been changed"]], 200);
          } catch (Exception $e) {
              	//if any operation fails, Thanos snaps finger - user was not created
				DB::rollBack();
             return response()->json(['data' => ['success' => true, 'message' => "Error changing password....try again"]], 500);
          }
       }

    }

}
