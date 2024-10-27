<?php

namespace App\Filter;
use Closure;

class StartDateFilter
{
    public function handle($request, Closure $next)
    {
        if(request()->filled('filter_start_date')){
            $request->where('created_at', '>=',request('filter_start_date'));
        }
        return $next($request);
    }

}
