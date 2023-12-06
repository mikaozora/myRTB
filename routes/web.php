<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Models\User;
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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::get('/sesi',[UserController::class, 'index'])->middleware([GuestMiddleware::class]);
Route::post('/sesi/login',[UserController::class, 'login'])->middleware([GuestMiddleware::class]);



Route::prefix('/penghuni')->middleware([MemberMiddleware::class])->group(function(){
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

Route::prefix("/dashboard")->middleware([MemberMiddleware::class])->group(function(){
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