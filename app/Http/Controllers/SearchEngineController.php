<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\JobOrders;
use App\Parts;
use App\Cars;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;

class SearchEngineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function search(Request $request)
    {	
        if($request->ajax()){
            $output = [];
            //joborders
            $orders = JobOrders::where('description', 'like', "%$request->search%")->limit(2)->get();
            //customers
            $clients = User::where('name' , 'like', "%$request->search%")->limit(2)->get();
            //cars
            $cars = Cars::where('model', 'like', "%$request->search%")->orWhere('manufacturer', 'like', "%$request->search%")->orWhere('vin', 'like', "$request->search%")->limit(2)->get();

            if($orders){
            	foreach ($orders as $key => $value) {
            		$info = [
            			'type' => 'jobs',
            			'id' => $value->id,
            			'description' => $value->description,
            		];
            		array_push($output, $info);
            	}
            }

            if($clients){
            	foreach ($clients as $key => $value) {
            		$info = [
            			'type' => 'clients',
            			'id' => $value->id,
            			'description' => $value->name,
            		];
            		array_push($output, $info);
            	}
            }

            if($cars){
                foreach ($cars as $key => $value) {
                    $info = [
                        'type' => 'car',
                        'id' => $value->id,
                        'description' => $value->manufacturer." ".$value->model." ".$value->number_plates,
                    ];
                    array_push($output, $info);
                }
            }

            return Response($output);
        }
    }

    public function searchSideBar($str)
    {
    	$data = [];
    	//oreder
        $orders = JobOrders::where('description', 'like', "%$str%")->get();
        //customers
        $clients = User::where('name' , 'like', "%$str%")->get();
        //cars
        $cars = Cars::where('model', 'like', "%$str%")->orWhere('manufacturer', 'like', "%$str%")->orWhere('vin', 'like', "$str%")->limit(2)->get();


        if($orders){
        	foreach ($orders as $key => $value) {
        		$info = [
        			'type' => 'jobs',
        			'id' => $value->id,
        			'description' => $value->description,
        		];
        		array_push($data, $info);
        	}
        }

        if($clients){
        	foreach ($clients as $key => $value) {
        		$info = [
        			'type' => 'clients',
        			'id' => $value->id,
        			'description' => $value->name,
        		];
        		array_push($data, $info);
        	}
        }

        if($cars){
            foreach ($cars as $key => $value) {
                $info = [
                    'type' => 'cars',
                    'id' => $value->id,
                    'description' => $value->manufacturer." ".$value->model." ".$value->number_plates,
                ];
                array_push($data, $info);
            }
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 25;
        $currentPageSearchResults = array_slice($data, (($currentPage - 1) * $perPage), $perPage);
        $pagination = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);
        $pagination->withPath(route('search').'/'.$str);
    	
        return view('dashboard.search.index', ['pagination' => $pagination]);
    }

    public function searchPart($str)
    {
        $partsResults = Parts::where('description', 'like', "%$str%")->orWhere('shortinfo', 'like', "%$str%")->orWhere('part_number', 'like', "$str%")->get();

        $result = [];
        array_push($result, $partsResults);

        //If only one result it;s redirecting directly to part page

        if(count($result[0]) === 1){
            return redirect()->route('part', ['id' => $result[0][0]->id]);
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 25;
        $currentPageSearchResults = array_slice($result, (($currentPage - 1) * $perPage), $perPage);
        $pagination = new LengthAwarePaginator($currentPageSearchResults, count($result), $perPage);
        $pagination->withPath(route('search').'/part/'.$str);
        
        return view('dashboard.parts.search', ['pagination' => $pagination, 'data' => $result]);
    }

    public function searchPartAjax(Request $request)
    {
        if($request->ajax()){
            $keywoard = $request->search;
            $output = Parts::where('description', 'like', "%$keywoard%")->orWhere('shortinfo', 'like', "%$keywoard%")->orWhere('part_number', 'like', "$keywoard%")->limit(6)->get();

            return Response($output);
        }
    }

    public function searchClient($str)
    {
        $clientResult = User::where('name', 'like', "%$str%")->orWhere('email', 'like', "%$str%")->orWhere('phone_number', 'like', "$str%")->paginate(25);
        return view('dashboard.clients.search', ['pagination' => $clientResult]);
    }

    public function searchClientAjax(Request $request)
    {
        if($request->ajax()){
            $keywoard = $request->search;
            $output = User::where('name', 'like', "%$keywoard%")->orWhere('email', 'like', "%$keywoard%")->orWhere('phone_number', 'like', "$keywoard%")->limit(6)->get();

            return Response($output);
        }
    }
}
