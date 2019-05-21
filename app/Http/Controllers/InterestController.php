<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index()
    {
        $interest = Interest::with('poll')->get();

        return response()->json($interest, 200);
    }
}