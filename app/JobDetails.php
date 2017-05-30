<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model
{
	protected $table = 'jobdetails';

    public function job()
    {
        return $this->belongsTo('App\JobOrders', 'id' ,'job_id');
    }

    public function formattedStatus()
    {
        switch($this->status){
            case 1:
                return 'In Order';
            case 2:
                return 'In Progress';
            case 3:
                return 'Done';
        }
    }

    public function employeeInfo()
    {
        return Employee::find($this->employee_id)->value('name');
    }
}
