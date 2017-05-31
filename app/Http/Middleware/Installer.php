<?php

namespace App\Http\Middleware;

use App\Employee;
use Closure;

class Installer
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
        try {
            Employee::first();

        } catch (\Illuminate\Database\QueryException $e) {
            return $next($request);
        }
        return redirect('/');

    }
}
