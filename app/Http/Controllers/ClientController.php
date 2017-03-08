<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cars;
use App\User;

use Log;

class ClientController extends Controller
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

    public function client()
    {
        if(Auth::user()->level >= 2){
            return view('dashboard.client');
        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }

    public function newclient(Request $request)
    {
        if(Auth::user()->level >= 2){

            $this->validate($request, [
                'description' => 'required|min:6',
            ]);

            $user = new User;

            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->passsword);
            $user->phone_number = $request->phone_number;
            $user->level = 1;

            $user->save();

            return back()->with('success', "New client added");

        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }
}
