<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('components.sidebaruser');
});

Route::get("/forum", function(){
    return view('penghuni.forum');
});

Route::prefix('/penghuni')->group(function(){
    Route::get("/forum", function(){
        return view('penghuni.forum');
    });
    Route::get("/mesincuci", function(){
        return view('penghuni.mesincuci');
    });
    Route::get("/coworking", function(){
        return view('penghuni.coworking');
    });
    Route::get("/dapur", function(){
        return view('penghuni.dapur');
    });
    Route::get("/history", function(){
        return view('penghuni.history');
    });
    Route::get("/serbaguna", function(){
        return view('penghuni.serbaguna');
    });
    Route::get("/report", function(){
        return view('penghuni.report');
    });
    Route::get("/theatre", function(){
        return view('penghuni.theatre');
    });
});

Route::prefix("/dashboard")->group(function(){
    Route::get("/forum", function(){
        return view('dashboard.forum');
    });
    Route::get("/mesincuci", function(){
        return view('dashboard.mesincuci');
    });
    Route::get("/coworking", function(){
        return view('dashboard.coworking');
    });
    Route::get("/dapur", function(){
        return view('dashboard.dapur');
    });
    Route::get("/penghuni", function(){
        return view('dashboard.penghuni');
    });
    Route::get("/serbaguna", function(){
        return view('dashboard.serbaguna');
    });
    Route::get("/report", function(){
        return view('dashboard.report');
    });
    Route::get("/theatre", function(){
        return view('dashboard.theatre');
    });
});