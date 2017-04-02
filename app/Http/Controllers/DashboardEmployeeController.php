<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobOrders;

class DashboardEmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.dashboard_employee');
    }
}
