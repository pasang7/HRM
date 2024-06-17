<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Auth;
use Session;
class Locked
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
        $is_locked=session('is_locked');
        if(session()->has('is_locked') && !$is_locked){
            return $next($request);
        }else{
            return redirect()->route('locked');
        }
        return $next($request);

        // return app(StartSession::class)->handle($request, function ($request) use ($next) {

        //     /** @var Response $response */
        //     $response = $next($request);
        //     $is_locked=session('is_locked');
        //     if(Auth::user()){
        //         return $response;
        //     }
        //     if(session()->has('is_locked') && !$is_locked){
        //         return $response;
        //     }else{
        //         return redirect()->route('locked');
        //     }
        // });
        
    }
}
