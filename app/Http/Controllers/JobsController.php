<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\JobOrders;
use App\History;
use App\Employee;
use App\JobDetails;
use App\Cars;

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
    public function index(Request $request)
    {   
        $jobs = JobOrders::orderBy('id', 'desc')->paginate(10);

        $scollumn = 'date';
        if(!$request->hsorted || $request->hsorted != 'desc' && $request->hsorted != 'asc'){
            $hsorted = 'desc';
        }else{
            $hsorted = $request->hsorted;
        }

        switch($request->swhat){
            case "date":
            $scollumn = "date";
            $jobs = JobOrders::orderBy('id', $hsorted)->paginate(10);
            break;

            case "progress":
            $scollumn = "progress";
            $jobs = JobOrders::orderBy('progress', $hsorted)->paginate(10);
            break;

            case "pirority":
            $scollumn = "pirority";
            $jobs = JobOrders::orderBy('pirority', $hsorted)->paginate(10);
            break;
        }

        $jobsArr = $jobs->toArray();

        $ordersStatus = [];
        $inOrder = JobOrders::where('progress', 1)->count('id');
        $inProgress = JobOrders::where('progress', 2)->count('id');
        $done = JobOrders::where('progress', 3)->count('id');

        array_push($ordersStatus, $inOrder, $inProgress, $done);

        foreach ($jobs as $key => $value) {

            $carInfo = Cars::find($value->car_id);
            if(!$carInfo){
                $jobsArr['data'][$key]['car'] = 'Car deleted';
            }else{
                $jobsArr['data'][$key]['car'] = $carInfo->carInfo();  
            }

            $jobsArr['data'][$key]['employee'] = $value->employee()->value('name');

            if(!$value->client()->value('name')){
                $jobsArr['data'][$key]['client'] = 'Customer deleted';
            }else{
                $jobsArr['data'][$key]['client'] = $value->client()->value('name');
            }

            switch ($value->progress) {
                case 1:
                    $jobsArr['data'][$key]['progress'] = "In order";
                    break;
                case 2:
                    $jobsArr['data'][$key]['progress'] = "In progress";
                    break;
                case 3:
                    $jobsArr['data'][$key]['progress'] = "Done";
                    break;
            }   

            switch ($value->pirority) {
                case 1:
                    $jobsArr['data'][$key]['pirority'] = "Normal";
                    break;
                case 2:
                    $jobsArr['data'][$key]['pirority'] = "High";
                    break;
                case 3:
                    $jobsArr['data'][$key]['pirority'] = "Urgent";
                    break;
            }
        }
        return view('dashboard.jobs.jobs', ['data' => $jobsArr, 'pagination' => $jobs, 'swhat' => $scollumn, 'show' => $hsorted, 'orderStatus' => $ordersStatus]);
    }

    public function indexDescription($id)
    {
        $result = JobOrders::findOrFail($id);

        $details = $result->details()->get();

        return view('dashboard.jobs.jobDescription', ['data' => $result, 'details' => $details]);
    }

    public function createJob()
    {
        return view('dashboard.jobs.joborder');
    }

    public function createJobAjax(Request $request)
    {
        if($request->ajax()){
            $this->validate($request, [
                'description' => 'required|max:255',
            ]);

            $order = new JobOrders;

            $order->employee_id = Auth::guard('employee')->id();
            $order->client_id = $request->client_id;
            $order->car_id = $request->car_id;
            $order->description = $request->description;
            $order->progress = 1;
            $order->pirority = $request->pirority;

            $order->save();

            // HistoryLog
            $oredrId = JobOrders::orderBy('id', 'desc')->first()->id;

            $history = new History;

            $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
            $history->description = 'Added new Job with id:' . $oredrId;

            $history->save();

            return Response($oredrId);
        }
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

        return view('dashboard.jobs.jobEdit', ['data' => $data]);
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
        JobDetails::where('job_id', $request->id)->delete();
        JobOrders::find($request->id)->delete();

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = "Deleted Order with id $request->id";

        $history->save();

        return redirect()->route('jobs')->with('success', "Order deleted successful");

    }

    public function DetAdd(Request $request)
    {
        // Add details

        $detail = new JobDetails;

        $detail->employee_id = Auth::guard('employee')->id();
        $detail->job_id = $request->joborder_id;
        $detail->description = $request->description;
        $detail->status = $request->status;

        $detail->save();

        //History

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = "Added detail with Id: " . JobDetails::orderBy('created_at', 'desc')->first()->id . " Description:" . $request->description .  " Status: " . $request->status;

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

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = "Updated detail with Id: $request->id Description: $request->description Status: $request->status";

        $history->save();

        return back()->with('success', "Detail updated successful");
    }

    public function DetDelete(Request $request)
    {
        // Delete details
        JobDetails::find($request->id)->delete();

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Deleted job details with id:' . $request->id;

        $history->save();

        return back()->with('success', "Detail deleted successful");
    }

}
