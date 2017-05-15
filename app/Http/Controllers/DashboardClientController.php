<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Cars;
use App\JobOrders;
use Hash;

class DashboardClientController extends Controller
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
        $user = User::find(Auth::id());
        $cars = $user->cars()->get();
        $carsCount = count($cars);

        return view('dashboard.dashboard_client', ['user' => $user, 'cars' => $cars, 'carsCount' => $carsCount]);
    }

    public function clientOrders()
    {
        $result = JobOrders::where('client_id', Auth::id())->orderBy('progress', 'asc')->paginate(25);

        $jobsArr = $result->toArray();

        foreach ($result as $key => $value) {

            $carInfo = Cars::where('id', $value->car_id)->get();
            $jobsArr['data'][$key]['car'] = $carInfo[0]->manufacturer." ".$carInfo[0]->model;


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
        }

        return view('dashboard.dashboard_client_orders', ['data' => $jobsArr, 'pagination' => $result]);
    }

    public function settings()
    {
        $data = Auth::user();
        return view('dashboard.settings.client', ['data' => $data]);
    }

    public function settingsSave(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Auth::id());
        $oldPassword = $user->password;

        if (!Hash::check($request->oldpassword, $oldPassword)){
            return back()->with('error', "Current password doesn't match!");
        }

        $passwordhash = Hash::make($request->password);

        $user->password = $passwordhash;

        $user->save();

        return back()->with('success', "Password changed successful!");
    }
}
