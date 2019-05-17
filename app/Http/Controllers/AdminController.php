<?php

namespace App\Http\Controllers;

use App\User;
use App\Poll;
use App\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

		return response()->json($users, 200);
    }

    public function polls()
    {
        $polls = Poll::orderBy('created_at', 'desc')->paginate(20);

		return response()->json($polls, 200);
    }

    public function trending()
    {
        $expirydate = DB::table('polls')->pluck('expirydate');

        if($expirydate >= 'CURRENT_TIMESTAMP'){
                $trending = DB::table('options')
                ->select('poll_id', DB::raw('count(*) as engagement'))
                ->groupBy('poll_id')
                ->orderBy('engagement', 'desc')
                ->take(10)
                ->get();           
                return response()->json($trending, 200);
            } else {
                return response()->json('No trending Post', 202);
        } 
    }
}
