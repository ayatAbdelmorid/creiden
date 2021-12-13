<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;
class userApi
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
        $user = User::where('api_token',$request->bearerToken())->first();
        if($user&&$request->bearerToken()&&( $user->api_token==$request->bearerToken())){
            return $next($request);
        }
        return response()->json(['error'=>'Authentication Error, user not authorized,'], 401);
    }
}
