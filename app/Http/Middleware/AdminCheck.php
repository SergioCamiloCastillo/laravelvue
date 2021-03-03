<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        \Log::info('inside middleware');
        if (!Auth::check()) {
            return response()->json([
                'msg' => 'this is a test'
            ], 402);
            //return redirect('/login');
        }
        return $next($request);
    }
}
