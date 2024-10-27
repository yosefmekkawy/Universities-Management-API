<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->hasHeader('lang')){
            if (request()->header('lang') == ''){
                app()->setLocale(app()->getLocale());
            }else{
                app()->setLocale(request()->header('lang'));
            }
        }else if (request()->has('lang')){
            app()->setLocale(request('lang'));
        }else if (request()->has('lang')){
            app()->setLocale(session('lang'));
        }
        return $next($request);
    }
}
