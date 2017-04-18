<?php

namespace App\Http\Middleware;

use Closure;
use App\Employee;

class CheckPermissions
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
        if($employeelevel <= 5){ 
            return redirect()->route('clients');
        }
        return $next($request);
    }
}
