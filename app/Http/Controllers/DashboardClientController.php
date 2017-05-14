<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Cars;
use App\JobOrders;

class DashboardClientController extends Controller
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
        $user = User::find(Auth::id());
        $cars = $user->cars()->get();
        $carsCount = count($cars);

        return view('dashboard.dashboard_client', ['user' => $user, 'cars' => $cars, 'carsCount' => $carsCount]);
    }

    // function Cars


    // function Orders/Jobs
}
