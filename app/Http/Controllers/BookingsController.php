<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests\BookingsRequest;

class BookingsController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        $guests = $request->guests ? $request->guests : 1;
        if (!is_numeric($guests)) {
            $guests = 1;
        }

        return view('bookings.create', compact(
            'event', 'guests'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BookingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingsRequest $request)
    {
        $event = Event::findOrFail($request->event_id);

        if (!$request->chargeAndBook(auth()->user(), $event)) {
            session()->flash('error', 'There was a problem with the credit card. Please review the credit card details and try again.');

            return back()
                ->withInput($request->all());
        }

        session()->flash('success', 'You have successfully booked for this event!');
        return redirect()->route('home');
    }
}
