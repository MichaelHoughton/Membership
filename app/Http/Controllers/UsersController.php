<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $events = Event::future()
            ->get();

        return view('users.index', compact(
            'user', 'events'
        ));
    }
}
