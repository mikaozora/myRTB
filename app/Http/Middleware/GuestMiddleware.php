<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
