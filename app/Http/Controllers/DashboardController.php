<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cars;
use App\JobOrders;


class DashboardController extends Controller
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
        return view('dashboard');
    }

    public function jobOrder()
    {
        if(Auth::user()->level >= 2){
            return view('dashboard.joborder');
        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }

    public function jobOrderPost(Request $request)
    {
        if(Auth::user()->level >= 2){
            $order = new JobOrders;

            $order->employee_id = Auth::id();
            $order->client_id = $request->client_id;
            $order->car_id = $request->car_id;
            $order->description = $request->description;
            $order->pirority = $request->pirority;

            $order->save();

        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }
}
