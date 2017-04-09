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
}
