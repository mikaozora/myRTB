<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(){
        return response()->view('penghuni.history', [
            "title" => "History"
        ]);
    }
}
