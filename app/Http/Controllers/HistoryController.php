<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request){
               
        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        return response()->view('penghuni.history', [
            "title" => "History",
            "photoProfile" => $photoProfile
        ]);
    }
}
