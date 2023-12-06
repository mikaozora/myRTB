<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index(){
        return response()->view('dashboard.penghuni', [
            "title" => "Penghuni"
        ]);
    }
}
