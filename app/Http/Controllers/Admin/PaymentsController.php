<?php

namespace App\Http\Controllers\Admin;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Payment::with('user')
            ->with('event')
            ->latest();

        if ($request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        $payments = $query->paginate();

        return view('admin.payments.index', compact('payments'));
    }
}
