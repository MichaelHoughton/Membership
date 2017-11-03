<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubscriptionsRequest;

class SubscriptionsController extends Controller
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

    public function index()
    {
        $user = auth()->user();

        if ($user->isMember()) {
            $subscription = $user->subscription(config('app.membership_name'));

            return view('subscriptions.index', compact('user', 'subscription'));
        }

        return view('subscriptions.create', compact('user'));
    }

    public function store(SubscriptionsRequest $request)
    {
        if (auth()->user()->isMember()) {
            abort(403, 'You don\'t have permission to access this page.');
        }

        if (!$request->subscribe(auth()->user())) {
            session()->flash('error', 'There was a problem with the credit card. Please review the credit card details and try again.');

            return redirect()
                ->route('subscriptions.index')
                ->withInput($request->all());
        }

        session()->flash('success', 'Your payment was successful and you have successfully subscribed!');
        return redirect()->route('subscriptions.index');
    }

    public function destroy()
    {
        if (!auth()->user()->isMember()) {
            abort(403, 'You don\'t have permission to access this page.');
        }

        auth()->user()->subscription(config('app.membership_name'))->cancel();

        session()->flash('success', 'Your subscription was successfully cancelled.');
        return redirect()->route('subscriptions.index');
    }
}
