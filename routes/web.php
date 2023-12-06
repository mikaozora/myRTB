<?php

use App\Http\Controllers\BookKitchenController;
use App\Http\Controllers\BookMachineController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SerbagunaController;
use App\Http\Controllers\TheatreController;
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
Route::post("/logout", [UserController::class, 'logout'])->middleware([MemberMiddleware::class]);



Route::prefix('/penghuni')->middleware([MemberMiddleware::class])->group(function(){
    Route::get("/forum", [ForumController::class, 'index']);
    Route::get("/mesincuci", [BookMachineController::class, 'index']);
    Route::get("/coworking", function(){
        return view('penghuni.coworking');
    });
    Route::get("/dapur", [BookKitchenController::class, 'index']);
    Route::get("/history", [HistoryController::class, 'index']);
    Route::get("/serbaguna", [SerbagunaController::class, 'index']);
    Route::get("/report", [ReportController::class, 'index']);
    Route::get("/theatre", [TheatreController::class, 'index']);
});

Route::prefix("/dashboard")->middleware([MemberMiddleware::class])->group(function(){
    Route::get("/forum", [ForumController::class, 'index']);
    Route::get("/mesincuci", [BookMachineController::class, 'index']);
    Route::get("/coworking", function(){
        return view('dashboard.coworking');
    });
    Route::get("/dapur", [BookKitchenController::class, 'index']);
    Route::get("/serbaguna", [SerbagunaController::class, 'index']);
    Route::get("/report", [ReportController::class, 'index']);
    Route::get("/theatre", [TheatreController::class, 'index']);
    Route::get("/penghuni", [PenghuniController::class, 'index']);
});