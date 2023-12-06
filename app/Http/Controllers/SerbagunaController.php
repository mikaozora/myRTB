<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SerbagunaController extends Controller
{
    public function index(Request $request){
        if($request->is('dashboard/*')){
            return response()->view('dashboard.serbaguna', [
                "title" => "Booking Serbaguna"
            ]);
        }
        return response()->view('penghuni.serbaguna', [
            "title" => "Booking Serbaguna"
        ]);
    }
}
