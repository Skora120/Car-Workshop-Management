<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\JobOrders;
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

            return Response($output);
        }
    }

    public function searchSideBar($string)
    {
    	$data = [];
    	//oreder
        $orders = JobOrders::where('description', 'like', "%$string%")->get();
        //customers
        $clients = User::where('name' , 'like', "%$string%")->get();

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

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 25;
        $currentPageSearchResults = array_slice($data, (($currentPage - 1) * $perPage), $perPage);
        $pagination = new LengthAwarePaginator($currentPageSearchResults, count($data), $perPage);
        $pagination->withPath(route('search').'/'.$string);
    	
        return view('dashboard.search.index', ['pagination' => $pagination]);
    }
}
