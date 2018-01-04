<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        //return $request->user();
        return response()->json(['msg'=>$request], 400);

         if (Auth::user() &&  Auth::user()->admin == 1) {
                return $next($request);
         }

        return response()->json(['msg'=>'Error, you are not an administrator'], 400);
    }
}
