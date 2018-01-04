<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthManager;

class IsAdmin
{
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }



    public function handle($request, Closure $next)
    {
        return response()->json(['msg'=>$this], 400);

         if (Auth::user() &&  Auth::user()->admin == 1) {
                return $next($request);
         }

        return response()->json(['msg'=>'Error, you are not an administrator'], 400);
    }
}
