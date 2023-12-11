<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request): RedirectResponse{
        
        if($request->session()->exists("NIP") && $request->session()->get('NIP')=="9999"){
            return redirect("/dashboard/forum");
        }else if($request->session()->exists("NIP")){
            return redirect("/penghuni/forum");
        }else{
            return redirect('/sesi');
        }
    }
}
