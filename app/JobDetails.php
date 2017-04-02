<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model
{
	protected $table = 'orderdetails';

    public function job()
    {
        return $this->belongsTo('App\JobOrders', 'id' ,'joborder_id');
    }
}
