<?php

namespace App\Filter;
use Closure;

class NameFilter
{
    public function handle($request, Closure $next)
    {
        if(request()->filled('filter_name')){
            $request->where('name', 'like', '%'.request('filter_name').'%');
        }
        return $next($request);
    }

}
