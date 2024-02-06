<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->exists("NIP") && $request->session()->get('NIP') != '9999'){
            return $next($request);
        }else{
            return redirect("/");
        }
    }
}


