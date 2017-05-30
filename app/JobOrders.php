<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrders extends Model
{
    public $table = 'joborders';

    public function employee()
    {
    	return $this->hasOne('App\Employee', 'id' ,'employee_id');
    }

    public function client()
    {
    	return $this->hasOne('App\User', 'id' ,'client_id');   
    }

    public function car()
    {
    	return $this->hasOne('App\Cars', 'client_id' ,'client_id');
    }

    public function details()
    {
        return $this->hasMany('App\JobDetails', 'job_id' ,'id');
    }
    public function carInfo()
    {
        $car = Cars::find($this->car_id);
        if(!$car){
            return "Car deleted";
        }
        return $car->manufacturer." ".$car->model;
    }

    public function customerName()
    {
        $user = User::find($this->client_id);
        if(!$user){
            return 'Customer deleted';
        }else{
            return $user->value('name');
        }
    }

    public function formattedProgress()
    {
        switch($this->progress){
            case 1:
                return 'In Order';
            case 2:
                return 'In Progress';
            case 3:
                return 'Done';
        }
    }

    public function formattedPirority()
    {
        switch($this->pirority){
            case 1:
                return 'Normal';
            case 2:
                return 'High';
            case 3:
                return 'Urgent';
        }
    }

    public function employeeInfo()
    {
        return Employee::find($this->employee_id)->value('name');
    }
}
