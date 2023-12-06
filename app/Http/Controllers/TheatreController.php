<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TheatreController extends Controller
{
    public function index(Request $request){
        if($request->is('dashboard/*')){
            return response()->view('dashboard.theatre', [
                "title" => "Booking Theatre"
            ]);
        }
        return response()->view('penghuni.theatre', [
            "title" => "Booking Theatre"
        ]);
    }
}
