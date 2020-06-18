<?php

namespace App\Http\Middleware;

use Closure;
use App\Track;


class CheckAuthor
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
        if( ! Track::where( 'slug' , trim( $request->route()->parameter('track') ) )->first()->u_id === $request->user()->id ){
            return abort(403);
        }
        return $next($request);
    }
}
