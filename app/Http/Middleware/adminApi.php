<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;
use Auth;
class adminApi
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
        $admin = Admin::where('api_token',$request->bearerToken())->first();
        if($admin&&$request->bearerToken()&&( $admin->api_token==$request->bearerToken())){
            return $next($request);
        }
        return response()->json(['error'=>'Authentication Error, user not authorized,'], 401);


    }
}
