<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SerbagunaController extends Controller
{
    public function index(Request $request){
               
        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        if($request->is('dashboard/*')){
            return response()->view('dashboard.serbaguna', [
                "title" => "Booking Serbaguna",
                "photoProfile" => $photoProfile
            ]);
        }
        return response()->view('penghuni.serbaguna', [
            "title" => "Booking Serbaguna",
            "photoProfile" => $photoProfile
        ]);
    }
}
