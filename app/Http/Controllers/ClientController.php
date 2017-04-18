<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Cars;
use App\User;
use App\History;
use App\Employee;
use App\JobOrders;
use Hash;
use Validator;
use Mail;

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

        if(!$result){
            return redirect()->route('clients')->with('error', "Customer with that ID does not exist!");
        }

        // Show profile and cars and magane
        $user = [
            'id' => $result->id,
            'name' => $result->name,
            'phone' => $result->phone_number,
            'email' => $result->email,
        ];

        $cars = Cars::where('client_id', $id)->get();

        $carNames = [];
        foreach ($cars as $key => $value) {
            $carNames[$value->id] = $value->manufacturer." ".$value->model;
        }

        $orders = JobOrders::where('client_id', $id)->orderBy('progress', 'desc')->paginate(15);

        return view('dashboard.clients.client', ['user' => $user, 'cars' => $cars, 'orders' => $orders, 'carsNames' => $carNames]);
    }

    public function newClient()
    {
        return view('dashboard.clients.newclient');
    }

    public function newClientPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'integer|required|digits_between:9,11'
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->withErrors($validator);
        }

        $username = 'k' . str_random(5);

        if(User::where('username', $username)->first()){
            $username = 'k' . str_random(8);
        }

        $password = str_random(8);
        $passwordhash = Hash::make($password);

        $user = new User;

        $user->username = $username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $passwordhash;
        $user->phone_number = $request->phone_number;

        $user->save();


        //send mail
        $requestMail = $request->email;

        $title = "Credentials";
        $contentLogin = $username;
        $contentPassword = $password;

        Mail::send('emails.credentials', ['title' => $title, 'login' => $contentLogin, 'password' => $contentPassword], function ($message) use ($requestMail){
            $message->from('me@gmail.com', 'Application');

            $message->to($requestMail);
        });

        //HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Added customer with name: ' . $request->name;

        $history->save();


        return redirect()->route('client', ['id' => $user->id])->with('success', "New client added");
    }
    //client update
    public function clientEdit(Request $request)
    {
        $user = User::find($request->id);


        if($user->email === $request->email){
            $this->validate($request, [
                'name' => 'string|required|max:255',
                'phone' => 'numeric|required|digits_between:9,11',
            ]);
        }else{
            $this->validate($request, [
                'name' => 'string|required|max:255',
                'phone' => 'numeric|required|max:11',
                'email' => 'unique:users|email|required',
            ]);
        }

        $user->name = $request->name;
        $user->phone_number = $request->phone;
        $user->email = $request->email;

        $user->save();

        //HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Edited customer with name:' . $request->name . "and id:" . $request->id;

        $history->save();


        return back()->with('success', "Customer updated!");
    }

    //client delte
    public function clientDelete(Request $request)
    {

        //Check level
        $employeelevel = Employee::find(Auth::guard('employee')->id())->value('level');
        if($employeelevel < 4){
            return back()->with('error', "You don't have permissions!");
        }

        $client = User::find($request->id);
        $clientName = $client->name;
        $client->delete();

        //History Log

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Deleted customer with name:' . $clientName . "and id:" . $request->id;

        $history->save();

        return redirect()->route('clients')->with('success', "Customer deleted!");
    }
}
    