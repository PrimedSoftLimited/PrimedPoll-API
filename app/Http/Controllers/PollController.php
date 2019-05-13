<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\Poll;
use App\Option;
use Cloudder;

class PollController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index(Poll $poll)
    {
        $user = Auth::guard('api')->user();

        $poll = Poll::where('user_id', $user->id)->get();

        return response()->json(['data' => ['success' => true, 'User Polls' => $poll]], 201);
    }

    public function show($id)
    {
        $user = Auth::guard('api')->user();
        $poll = Poll::findOrFail($id);
        try{

            if($user->id == $poll->user_id){

            return response()->json(['data' => ['success' => true, 'Poll' => $poll, 'message' => 'User Poll']], 201);

            }

        }   catch(Exception $e){

            return response()->json(['data' => ['success' => false, 'message: '.$e->getMessage('Poll does not exist!!')]], 401);

        }
    }


    public function createpoll(Request $request)
    {
        $this->validate($request, [
            'pollname' => 'required|min:4',
            'interest_id' => 'required',
            'expirydate' => 'required',
            'options' => 'required',
        ]);

        $poll = new Poll;
        $AuthenticatedUser = Auth::user();

        // $poll->user_id = 1;
        if ($AuthenticatedUser) {
            $poll->user_id = $AuthenticatedUser->id;
            $poll->name = $request->input('pollname');
            $poll->interest_id = $request->input('interest_id');
            $poll->expirydate = $request->input('expirydate');
            $poll->save();

            if ($request->hasFile('options') && $request->file('options')) {
                foreach ($request->file('options') as $file) {
                    $filename = $file->getClientOriginalName();
                    $image_name = $file->getRealPath();
                    Cloudder::upload($image_name, null);
                    $cloudResult = Cloudder::getResult();
                    $imagename = $cloudResult['url'];
                    if ($cloudResult) {
                        $poll_id = $poll->id;
                        $optionsModel = new Option;
                        $optionsModel->name = $imagename;
                        $optionsModel->poll_id = $poll_id;
                        $optionsModel->save();
                    }
                }
                // return 'yes';
                return response()->json(['data' => ['success' => true, 'message' => 'Poll created', 'Poll' => $poll, 'options' => $optionsModel]], 201);
            } elseif ($request->has('options')) {

                $text = $request->options;
                $splitByLine = explode("\n", $text);
                foreach ($splitByLine as $singleOption) {
                    $poll_id = $poll->id;
                    $optionsModel = new Option;
                    $optionsModel->name = $singleOption;
                    $optionsModel->poll_id = $poll_id;
                    $optionsModel->save();
                }
                return response()->json(['data' => ['success' => true, 'message' => 'Poll created', 'Poll' => $poll, 'options' => $optionsModel]], 201);
            }
        } else {
            return response()->json(['data' => ['success' => false, 'message' => 'Unauthorized access']], 401);
        }
    }

    public function delete($id)
    {
        $poll = Poll::findOrFail($id);

        $poll->delete();
        
        return response()->json(['data' => ['success' => true, 'message' => 'User Poll Deleted Successfully!!']], 201);
    }

}
