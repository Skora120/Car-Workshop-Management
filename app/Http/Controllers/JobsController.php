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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level >= 2){
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

                Log::info($value->created_at);

                $data[$key] = [
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
        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }

    public function jobOrder()
    {
        if(Auth::user()->level >= 2){
            return view('dashboard.joborder');
        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }

    public function jobOrderPost(Request $request)
    {
        if(Auth::user()->level >= 2){

            Log::info($request);

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

        }else{
            return back()->with('failed', "You don't have acces to this page");
        }
    }
}
