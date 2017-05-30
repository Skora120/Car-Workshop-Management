<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    public function client()
    {
        return $this->hasOne('App\User','id','client_id');
    }

    public function carInfo()
    {
        return $this->manufacturer." ".$this->model;
    }
}
