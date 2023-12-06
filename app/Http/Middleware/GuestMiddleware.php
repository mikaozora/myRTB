<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->exists("NIP")){
            return redirect("/");
        }else{
            return $next($request);
        }
       
    }
}
