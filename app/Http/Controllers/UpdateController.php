<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use libphonenumber\PhoneNumberType;



class UpdateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    //

    public function validateRequest(Request $request)
    {

       $rules = [
        'first_name' => 'users,first_name,string',
        'last_name' => 'users,last_name,string',
        'phone' => 'users,phone,required|phone:NG,US,mobile',
        'dob' => 'date',
        'category' => 'string',
        ];

        $messages = [
            'required' => ':attribute is required',
            'phone' => ':attribute number is invalid'
        ];

        $this->validate($request, $rules);

    }

    public function update(Request $request, $id)
    {
       
        $user = User::findorFail($id);

        if($user->id === $id){

        $this->validateRequest($request);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        $user->category = $request->input('category');
       
        $user->save();
		$res['message'] = "{$user->first_name} Updated Successfully!";        
        return response()->json($res, 200); 
       }

       else{

        $res['message'] = "{$user->first_name} Update Failed!!";        
        return response()->json($res, 400);

       }
       
    }
}
