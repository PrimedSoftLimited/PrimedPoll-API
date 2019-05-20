<?php

namespace App\Http\Controllers;

use App\Poll;
use App\User;
use App\Intrest;
use App\Userinterest;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPollController extends Controller
{    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index()
    {
        $poll = Poll::where('owner_id', Auth::user()->id)
                ->with('options')
                ->withCount('votes')
                ->get();
        return response()->json($poll, 200);
    }

    public function show($id)
    {   
        $pollCheck = Poll::findOrFail($id);

        if(Auth::user()->id == $pollCheck->owner_id)
            {
                $poll = Poll::where('id', $id)
                    ->with('options')
                    ->withCount('votes')
                    ->get();
                return response()->json($poll, 200);
            }
            return response()->json('Unauthorized Access!', 400);
    }

    public function create(Request $request, $id)
    {
        $interest = Userinterest::findOrFail($id);

        if(Auth::user()->id == $interest->owner_id)
        {
            $this->validatePoll($request);
            $poll = new Poll;
            if(!Poll::where('name', $request->input('name'))->where('interest_id', $interest->id)->exists())
                {
                    $poll->name = $request->input('name');
                    $poll->startdate = $request->input('startdate');
                    $poll->expirydate = $request->input('expirydate');
                    $poll->interest_id = $interest->id;
                    $poll->owner_id = Auth::user()->id;
                    $poll->save();
    
                    $res['status'] = "{$poll->name} Created Successfully!";
                    $res['poll'] = $poll;
                    return response()->json($res, 201);
                
                 } return response()->json('Poll exist for Interest', 400);
            } return response()->json('Please Select Interest Before Creating Poll');
    }

    public function update(Request $request, $id)
    {
        $pollCheck = Poll::where('id', $id)->exists();
        $poll = Poll::findOrFail($id);

        if(Auth::user()->id == $poll->owner_id)
        {
            if($pollCheck)
            {
                $this->validatePoll($request);

                $poll->name = $request->input('name');
                $poll->startdate = $request->input('startdate');
                $poll->expirydate = $request->input('expirydate');
                $poll->save();

                $res['status'] = "{$poll->name} Created Successfully!";
                $res['poll'] = $poll;
                return response()->json($res, 201);

            } return response()->json('Poll Does not Exist', 400);

        } return response()->json('Unauthorized Acess', 400);

    }
    
    public function destroy(Request $request, $id)
    {
        $pollCheck = Poll::where('id', $id)->exists();
        $poll = Poll::findOrFail($id);

        if(Auth::user()->id == $poll->owner_id)
        {
            if($pollCheck)
            {
                $poll->delete();
            
                $res['status'] = "Deleted Successfully!";
                return response()->json($res, 201);

            } return response()->json('Poll Does not Exist', 400);

        } return response()->json('Unauthorized Acess', 400);
                        
    }

    public function validatePoll(Request $request){

		$rules = [
            'name' => 'required|min:3',
            'startdate' => 'required|date|before:expirydate',
            'expirydate' => 'required|date|after:startdate',
        ];
         
		$this->validate($request, $rules);
    }

}
