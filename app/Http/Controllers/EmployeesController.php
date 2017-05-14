<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\History;
use Auth;
use Validator;
use Hash;
use Mail;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:employee', 'employee.permissions']);

    }

    public function index()
    {
    	$employees = Employee::orderBy('level', 'desc')->paginate(20);
    	return view('dashboard.employees.index', ['data' => $employees]);
    }

    public function indexDescription($id)
    {
    	$data = Employee::find($id);
    	if(!$data){
    		return view('dashboard.employees.notFound');
    	}

    	return view('dashboard.employees.profile', ['data' => $data]);
    }

    public function employeeAdd(Request $request)
    {   	
        $validator = Validator::make($request->all(), [
        	'name' => 'required|max:255',
        	'username' => 'required|unique:employees',
            'email' => 'required|email|max:255|unique:employees',
            'phone_number' => 'integer|required|digits_between:9,11',
            'level' => 'integer|required|max:7',
        ]);

        if($validator->fails()){
            return back()->withInput($request->all())->withErrors($validator);
        }

        $password = str_random(8);
        $passwordhash = Hash::make($password);

        $employee = new Employee;

        $employee->username = $request->username;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = $passwordhash;
        $employee->phone_number = $request->phone_number;
        $employee->level = $request->level;

        $employee->save();


        //send mail
        $requestMail = $request->email;

        $title = "Credentials";
        $contentLogin = $request->username;
        $contentPassword = $password;

        Mail::send('emails.credentials', ['title' => $title, 'login' => $contentLogin, 'password' => $contentPassword], function ($message) use ($requestMail){
            $message->from('me@gmail.com', 'Application');

            $message->to($requestMail);
        });

        //HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Added employee with name: ' . $request->name;

        $history->save();


        return redirect()->route('employee', ['id' => $employee->id])->with('success', "New employee added");
    }

    public function employeeEdit(Request $request)
    {
        $user = Employee::find($request->id);

        $maxlevel = Employee::find(Auth::guard('employee')->id())->value('level');

        if($user->email === $request->email){
            $this->validate($request, [
                'name' => 'string|required|max:255',
                'phone_number' => 'numeric|required|digits_between:9,11',
                'level' => 'numeric|required|max:'.$maxlevel,
            ]);
        }else{
            $this->validate($request, [
                'name' => 'string|required|max:255',
                'email' => 'unique:users|email|required',
                'phone_number' => 'numeric|required|digits_between:9,11',
                'level' => 'numeric|required|max:'.$maxlevel,
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->level = $request->level;

        $user->save();

        //HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Edited employee with name:' . $request->name . "and id:" . $request->id;

        $history->save();

        return back()->with('success', "Employee updated!");
    }

    public function employeeDelete(Request $request)
    {
        $employee = Employee::find($request->id);
        $employeeName = $employee->name;
        $employee->delete();

        //History Log

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Deleted employee with name:' . $employeeName . "and id:" . $request->id;

        $history->save();

        return redirect()->route('employees')->with('success', "Employee deleted!");
    }
}
