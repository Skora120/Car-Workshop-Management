<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\JobOrders;
use App\History;
use App\Employee;
use App\JobDetails;

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
        return view('dashboard.jobs.jobs', ['data' => $data]);
    }

    public function indexDescription($id)
    {
        $result = JobOrders::find($id);

        if(empty($result)){
            return view('dashboard.jobs.jobNotFound');
        }

        $details = $result->details()->get();

        return view('dashboard.jobs.jobDescription', ['data' => $result, 'details' => $details]);
    }

    public function createJob()
    {
        return view('dashboard.jobs.joborder');
    }

    public function createJobPost(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required',
            'car_id' => 'required',
            'pirority' => 'required',
            'description' => 'min:8',
        ]);

        $order = new JobOrders;

        $order->employee_id = Auth::id();
        $order->client_id = $request->client_id;
        $order->car_id = $request->car_id;
        $order->description = $request->description;
        $order->progress = 1;
        $order->pirority = $request->pirority;

        $order->save();

        // HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::id())->value('username');
        $history->description = 'Added new Job with id:' . JobOrders::orderBy('created_at', 'desc')->first()->id;

        $history->save();

        return back()->with('success', "New order added");
    }

    public function indexDescEdit($id)
    {   
        $joborder = JobOrders::find($id);
        $jobdetails = $joborder->details()->get();
        

        $data = (object)[
            'id' => $joborder->id,
            'client_id' => $joborder->client_id,
            'car_id' => $joborder->car_id,
            'description' => $joborder->description,
            'progress'  => $joborder->progress,
            'pirority' => $joborder->pirority,
            'details' => $jobdetails,
        ];

        return view('dashboard.jobs.jobedit', ['data' => $data]);
    }

    public function OrderEditPut(Request $request)
    {   
        $joborder = JobOrders::find($request->id);

        $joborder->client_id = $request->client_id;
        $joborder->car_id = $request->car_id;
        $joborder->description = $request->description;
        $joborder->progress = $request->progress;
        $joborder->pirority = $request->pirority;

        $joborder->save();

        return back()->with('success', "Order main information edited successful");

    }

    public function OrderDelete(Request $request)
    {   
        /// Delete Order
        JobDetails::where('joborder_id', $request->id)->delete();
        JobOrders::find($request->id)->delete();

        $history = new History;

        $history->username = Employee::find(Auth::id())->value('username');
        $history->description = "Deleted Order with id $request->id";

        $history->save();

        return redirect()->route('jobs')->with('success', "Order deleted successful");

    }

    public function DetAdd(Request $request)
    {
        // Add details

        $detail = new JobDetails;

        $detail->employee_id = Auth::id();
        $detail->joborder_id = $request->joborder_id;
        $detail->description = $request->description;
        $detail->status = $request->status;

        $detail->save();

        //History

        $history = new History;

        $history->username = Employee::find(Auth::id())->value('username');
        $history->description = "Added detail with Id: JobDetails::orderBy('created_at', 'desc')->first()->id Description: $request->description Status: $request->status";

        $history->save();

        return back()->with('success', "Detail added successful");
    }

    public function DetEditPut(Request $request)
    {
        // Edit details
        $detail = JobDetails::find($request->id);

        $detail->description = $request->description;
        $detail->status = $request->status;

        $detail->save();

        //History

        $history = new History;

        $history->username = Employee::find(Auth::id())->value('username');
        $history->description = "Updated detail with Id: $request->id Description: $request->description Status: $request->status";

        $history->save();

        return back()->with('success', "Detail updated successful");
    }

    public function DetDelete(Request $request)
    {
        // Delete details
        JobDetails::find($request->id)->delete();

        $history = new History;

        $history->username = Employee::find(Auth::id())->value('username');
        $history->description = 'Deleted job details with id:' . $request->id;

        $history->save();

        return back()->with('success', "Detail deleted successful");
    }

}
