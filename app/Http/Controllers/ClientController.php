<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cars;
use App\User;
use Hash;
use Validator;

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
        $this->middleware('auth:employee');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::all();

        foreach ($result as $key => $value) {
            $client = User::find($value->id);
            $cars_count = $client->cars()->count();
            $result[$key]['cars_count'] = $cars_count;
        }


        return view('dashboard.clients.clients', ['data' => $result]);
    }

    public function indexDescription($id)
    {
        $result = User::find($id);

        // Show profile and cars and magane
        $data = ['test' => 'test'];




        return view('dashboard.clients.client', ['data' => $data]);
    }

    public function newClient()
    {
        return view('dashboard.clients.newclient');
    }

    public function newClientPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255|min:8',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'phone_number' => 'required|max:11'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->withErrors($validator);
        }

        $password = Hash::make($request->password);

        $user = new User;

        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $password;
        $user->phone_number = $request->phone_number;

        $user->save();

        return back()->with('success', "New client added");
    }
    //client update

    //client delte


}
