<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!auth()->guard('admin')->check()) {
            session()->flash('message', 'You are Unauthorized to Access. Further action Please Login.');
            session()->flash('type', 'danger');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
