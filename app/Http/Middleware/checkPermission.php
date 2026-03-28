<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class checkPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        if($permission && (!$request->user() || !$request->user()->can($permission))) {
            return Redirect::to('/dashboard')->with('error', 'لا تملك صلاحية للوصول إلى هذه الصفحة');
        }
        return $next($request);
    }
}
