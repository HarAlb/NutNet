<?php

namespace App\Http\Middleware;

use Closure;
use App\Track;

class SlugExist
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

        if( !Track::where( 'slug' , trim( $request->route()->parameter('track') ) )->first() ){
            return abort(404);
        }

        return $next($request);
    }
}
