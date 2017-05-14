<?php

namespace App\Http\Middleware;

use Closure;
use App\Employee;

class CheckPermissionsHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $employeelevel = Employee::find($request->user()->id)->value('level');
        if($employeelevel <= 6){ 
            return redirect()->route('dashboard-employee');
        }
        return $next($request);
    }
}
