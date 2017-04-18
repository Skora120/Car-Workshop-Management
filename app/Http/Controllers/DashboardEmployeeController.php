<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;
use Validator;
use Hash;

use Log;

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
        $level = Auth::user()->level;
        return view('dashboard.dashboard_employee', ['level' => $level]);
    }

    public function settings()
    {
        $data = Auth::user();
        return view('dashboard.settings.employee',['data' => $data]);
    }

    public function settingsPasswordSave(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Employee::find(Auth::id());
        $oldPassword = $user->password;

        if (!Hash::check($request->oldpassword, $oldPassword)){
            return back()->with('error', "Current password doesn't match!");
        }

        $passwordhash = Hash::make($request->password);

        $user->password = $passwordhash;

        $user->save();

        return back()->with('success', "Password changed successful!");
    }

    public function settingsPhoneSave(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'integer|required|digits_between:9,11',
        ]);

        $user = Employee::find(Auth::id());

        $user->phone_number = $request->phone_number;

        $user->save();

        return back()->with('success', "Phone number changed successful!");
    }
}
