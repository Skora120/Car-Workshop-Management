<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parts extends Model
{
	public function employeeInfo()
	{
        return Employee::find($this->employee_id)->value('name');
	}
}
