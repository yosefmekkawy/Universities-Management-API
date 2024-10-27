<?php

namespace App\Filter;
use Closure;

class EndDateFilter
{
    public function handle($request, Closure $next)
    {
        if(request()->filled('filter_end_date')){
            $request->where('created_at', '<=',request('filter_end_date'));
        }
        return $next($request);
    }

}
