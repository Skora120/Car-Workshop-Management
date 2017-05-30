<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cars;
use App\Employee;
use App\User;
use App\History;
use Validator;
use Auth;

use Log;

class CarsController extends Controller
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
        $cars = Cars::orderBy('id', 'desc')->paginate(25);
        return view('dashboard.cars.cars', ['pagination' => $cars]);
    }

    public function indexDescription($id)
    {
        $car = Cars::find($id);

        if(!$car){
            return view('dashboard.cars.notFound');
        }        

        $owner =  User::find($car->client_id);
        if(!$owner){
        $ownerdata = (object)[
            'id' => $car->client_id,
            'name' => "Customer Deleted"
        ];
        }else{
        $ownerdata = (object)[
            'id' => $owner->id,
            'name' => $owner->name
        ];
        }
        return view('dashboard.cars.car', ['data' => $car, 'owner' => $ownerdata]);
    }

    public function carAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'manufacturer' => 'required|max:255',
            'model' => 'required|max:255',
            'color' => 'required|max:255',
            'engine' => 'required|max:255',
            'vin' => 'required|max:17',
            'year' => 'required|integer|digits:4',
            'number_plates' => 'required|max:10',
            'milage' => 'required|integer'
        ]);

    	$car = new Cars;

    	$car->manufacturer = $request->manufacturer;
    	$car->model = $request->model;
    	$car->color = $request->color;
    	$car->engine = $request->engine;
    	$car->year = $request->year;
    	$car->client_id = $request->id;
    	$car->vin = $request->vin;
    	$car->number_plates = $request->number_plates;
    	$car->milage =  $request->milage;

    	$car->save();

        //HistoryLog

    	$customer = User::find($request->id)->value('name');

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Added car to customer: ' . $customer . ", car: " . "$request->manufacturer $request->model";

        $history->save();


        return back()->with('success', "Car added successful!");

    }

    public function carEdit($id)
    {
        $data = Cars::find($id);
    	return view('dashboard.cars.edit', ['data' => $data]);
    }

    public function carEditPut(Request $request)
    {
        $this->validate($request, [
            'manufacturer' => 'required|max:255',
            'model' => 'required|max:255',
            'color' => 'required|max:255',
            'engine' => 'required|max:255',
            'vin' => 'required|max:17',
            'year' => 'required|integer|digits:4',
            'number_plates' => 'required|max:10',
            'milage' => 'required|integer'
        ]);

        $car = Cars::find($request->id);

        $car->manufacturer = $request->manufacturer;
        $car->model = $request->model;
        $car->color = $request->color;
        $car->engine = $request->engine;
        $car->year = $request->year;
        $car->client_id = $request->id;
        $car->vin = $request->vin;
        $car->number_plates = $request->number_plates;
        $car->milage =  $request->milage;

        $car->save();

        //HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Updated car information. Car id: ' . $request->id;

        $history->save();

        return back()->with('success', "Car edited successful!");
    }

    public function carDelete(Request $request)
    {
        //Check level
        $employeelevel = Employee::find(Auth::guard('employee')->id())->value('level');
        if($employeelevel < 4){
            return back()->with('error', "You don't have permissions!");
        }

        $car = Cars::find($request->id);
        $client_id = $car->client_id;
        $car->delete();

        //HistoryLog

        $history = new History;

        $history->username = Employee::find(Auth::guard('employee')->id())->value('username');
        $history->description = 'Car with id ' . $request->id;

        $history->save();

        return redirect()->route('client', ['id' => $client_id])->with('success', "Car deleted!");
    }
}
