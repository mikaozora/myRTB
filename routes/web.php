<?php

use App\Http\Controllers\BookKitchenController;
use App\Http\Controllers\BookMachineController;
use App\Http\Controllers\BookRoomController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SerbagunaController;
use App\Http\Controllers\TheatreController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\LogoutMiddleware;
use App\Http\Middleware\MemberMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use APp\Events\ChatForum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
Route::post("/logout", [UserController::class, 'logout'])->middleware([LogoutMiddleware::class]);


Route::prefix("/dashboard")->middleware([AdminMiddleware::class])->group(function(){
    Route::controller(ForumController::class)->group(function(){
        Route::get("/forum",'index');
        Route::post("/forum/send-msg",'sendMessage');
    });

    Route::get("/mesincuci", [BookMachineController::class, 'index']);
    Route::get("/coworking", [RoomController::class, 'index']);
    Route::get("/dapur", [BookKitchenController::class, 'index']);
    Route::get("/serbaguna", [SerbagunaController::class, 'index']);
    Route::get("/report", [ReportController::class, 'index']);
    Route::get("/theatre", [TheatreController::class, 'index']);
    Route::controller(PenghuniController::class)->group(function(){
        Route::get("/penghuni", 'index');
        Route::post("/penghuni", 'create');
        Route::put("/penghuni/{NIP}", 'update');
        Route::delete("/penghuni/{NIP}", 'destroy');
    });
});


Route::prefix('/penghuni')->middleware([MemberMiddleware::class])->group(function(){
    Route::controller(ForumController::class)->group(function(){
        Route::get("/forum",'index');
        Route::post("/forum/send-msg",'sendMessage');
    });
    Route::get("/mesincuci", [BookMachineController::class, 'index']);
    Route::controller(BookMachineController::class)->group(function()
    {
        Route::get("/mesincuci", "index");
        Route::post("/mesincuci", "bookMesinCuci");
    });
    Route::controller(RoomController::class)->group(function(){
        Route::get("/coworking", 'index');
        Route::post("/coworking", 'bookCWS');
    });
    Route::controller(BookKitchenController::class)->group(function(){
        Route::get("/dapur", 'index');
        Route::post("/dapur", 'create');
    });
    Route::controller(HistoryController::class)->group(function(){
        Route::get('/history', 'index');
        Route::put('/history/{id}', 'uploadPhoto');
    });
    Route::get("/serbaguna", [SerbagunaController::class, 'index']);
    Route::controller(ReportController::class)->group(function(){
        Route::get("/report", 'index');
        Route::post("/report", 'sendReport');
    });
    Route::controller(TheatreController::class)->group(function(){
        Route::get("/theatre", 'index');
        Route::post("/theatre", 'book');
    });
});
