<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class EmployeeLoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest:employee');
	}

    public function showLoginForm()
    {
    	return view('auth.login_employee');
    }

    public function login(Request $request)
    {
    	//Validate the form data
    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required|min:6',
    	]);

    	//Attempt to login
    	$credentials = ['username' => $request->username, 'password' => $request->password];
    	if(Auth::guard('employee')->attempt($credentials, $request->remember)){
			//if successful, then redirect to thier intended location
			return redirect()->intended(route('dashboard-employee'));
    	}else{
        	//if unsuccessful, then redirect back to the login with the form data, except password
            $errors = ['msg' => "Wrong username or password"];
        	return redirect()->back()->withErrors($errors)->withInput($request->only('username','remember'));
        }
    }
}
