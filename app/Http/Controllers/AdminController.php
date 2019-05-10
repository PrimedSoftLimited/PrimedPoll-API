<?php

namespace App\Http\Controllers;

use App\User;
use App\Poll;
use App\Admin;
use Illuminate\Http\Request;
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
}
