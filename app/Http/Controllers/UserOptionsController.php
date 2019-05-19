<?php

namespace App\Http\Controllers;

use App\User;
use App\Poll;
use App\Option;
use App\Intrest;
use App\Userinterest;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOptionsController extends Controller
{    
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function show($id)
    {   
        $optionCheck = Option::findOrFail($id);

        if(Auth::user()->id == $optionCheck->owner_id)
            {
                $option = Option::where('id', $id)
                    ->withCount('votes')
                    ->get();
                return response()->json($option, 200);
            }
            return response()->json('Unauthorized Access!', 400);
    }

    public function create(Request $request, $id)
    {
        $poll = Poll::findOrFail($id);

        if(Auth::user()->id == $poll->owner_id)
        {
            $this->validatePoll($request);
            $option = new Option;
            if(!Option::where('name', $request->input('name'))->where('poll_id', $poll->id)->exists())
                {
                    $option->name = $request->input('name');
                    $option->owner_id = Auth::user()->id;
                    $option->poll_id = $poll->id;

                    $option->save();
    
                    $res['status'] = "Success";
                    $res['option'] = $option;
                    return response()->json($res, 201);
                
                 } return response()->json('Option exist for Poll', 400);

            } return response()->json('Unauthorized');
    }

    public function update(Request $request, $id)
    {
        $option = Option::findOrFail($id);

        if(Auth::user()->id == $option->owner_id)
        {
            $this->validatePoll($request);

                $option->name = $request->input('name');
                $option->save();

                $res['status'] = "Updated Successfully!";
                $res['option'] = $option;
                return response()->json($res, 201);
            
        } return response()->json('Unauthorized Acess', 400);

    }
    
    public function destroy(Request $request, $id)
    {
        $option = Option::findOrFail($id);

        if(Auth::user()->id == $option->owner_id)
        {
                $option->delete();

                $res['status'] = "Deleted Successfully!";
                return response()->json($res, 201);
            
        } return response()->json('Unauthorized Acess', 400);
    }

    public function validatePoll(Request $request){

		$rules = [
            'name' => 'required|min:3',
        ];
		$this->validate($request, $rules);
    }

}
