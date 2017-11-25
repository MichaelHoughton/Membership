<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Booking::with('event')
            ->with('payment.user')
            ->latest();

        if ($request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        $bookings = $query->paginate();

        return view('admin.bookings.index', compact('bookings'));
    }
}
