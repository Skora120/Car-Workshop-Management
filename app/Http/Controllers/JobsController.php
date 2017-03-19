<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\JobOrders;

use Log;

class JobsController extends Controller
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
        $jobs = JobOrders::orderBy('pirority', 'desc')->get();

        $data = [];
        foreach ($jobs as $key => $value) {

            $carInfo = $value->car()->get();
            $carInfo = $carInfo[0]->manufacturer." ".$carInfo[0]->model;

            $employeeInfo = $value->employee()->value('name');

            $clientInfo = $value->client()->value('name');

            $progress;
            switch ($value->progress) {
                case 1:
                    $progress = "In order";
                    break;
                case 2:
                    $progress = "In progress";
                    break;
                case 3:
                    $progress = "Done";
                    break;
            }   

            $pirority;
            switch ($value->pirority) {
                case 1:
                    $pirority = "Normal";
                    break;
                case 2:
                    $pirority = "High";
                    break;
                case 3:
                    $pirority = "Urgent";
                    break;
            }

            $data[$key] = [
            'id' => $value->id,
            'data' => $value->created_at,
            'progress' => $progress,
            'description' => $value->description,
            'employee' => $employeeInfo,
            'client' => $clientInfo,
            'car' => $carInfo,
            'pirority' => $pirority
            ];
        }
        return view('dashboard.jobs', ['data' => $data]);
    }

    public function indexDescription($id)
    {
        $result = JobOrders::where('id', $id)->get();

        return view('dashboard.jobEmp', ['data' => $result]);
    }

    public function createJob()
    {
        return view('dashboard.joborder');
    }

    public function createJobPost(Request $request)
    {
        $this->validate($request, [
            'description' => 'min:8',
        ]);

        $order = new JobOrders;

        $order->employee_id = Auth::id();
        $order->client_id = $request->client_id;
        $order->car_id = $request->car_id;
        $order->description = $request->description;
        $order->pirority = $request->pirority;

        $order->save();

        return back()->with('success', "New order added");
    }
}
