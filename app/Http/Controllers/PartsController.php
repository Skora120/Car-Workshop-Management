<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parts;
use App\User;
use App\History;
use App\Employee;
use Auth;

use Log;

class PartsController extends Controller
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
		$result = Parts::paginate(20);


		return view('dashboard.parts.parts', ['data' => $result]);
	}

	public function addPart(Request $request)
	{
		$employee_id = Auth::guard('employee')->id();

		$data = new Parts;

		$data->employee_id = $employee_id;
		$data->description = $request->description;
		$data->amount = $request->amount;
		$data->part_number = $request->part_number;
		$data->shortinfo = $request->shortinfo;

		$data->save();

		$history = new History;

        $history->username = Employee::find($employee_id)->value('username');
        $history->description = 'Added part with id:' . $data->id;

        $history->save();

        return back()->with('success', "Part added successful");
	}

	public function editPart(Request $request)
	{
		$employee_id = Auth::guard('employee')->id();
		$data = Parts::find($request->id);

		$data->employee_id = $employee_id;
		$data->description = $request->description;
		$data->shortinfo = $request->shortinfo;
		$data->amount = $request->amount;
		$data->part_number = $request->part_number;
		
		$data->save();

		$history = new History;

        $history->username = Employee::find($employee_id)->value('username');
        $history->description = 'Edited part with id:' . $data->id;

        $history->save();

        return back()->with('success', "Part information edited successful");

	}

	public function deletePart(Request $request)
	{
		$employee_id = Auth::guard('employee')->id();
		$data = Parts::find($request->id);
		$data->delete();

		$history = new History;

        $history->username = Employee::find($employee_id)->value('username');
        $history->description = 'Deleted part with id: ' . $request->id . ' information:' . $data->description . ' , ' . $data->shortinfo;

        $history->save();

        return back()->with('success', "Part deleted successful");
	}
}
