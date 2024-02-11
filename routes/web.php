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
use App\Http\Middleware\CheckRouteMiddleware;
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
Route::put("/change-password", [UserController::class, 'change_password'])->middleware([LogoutMiddleware::class]);
Route::post('/verify-password', [UserController::class, 'verifyPassword']);

Route::prefix("/dashboard")->middleware([AdminMiddleware::class])->group(function(){
    Route::controller(ForumController::class)->group(function(){
        Route::get("/forum",'index');
        Route::post("/forum/send-msg",'sendMessage');
    });
    
    Route::controller(BookMachineController::class)->group(function()
    {
        Route::get('/mesincuci', 'index');
    });

    Route::controller(RoomController::class)->group(function()
    {
        Route::get('/coworking', 'index');
    });

    Route::controller(BookKitchenController::class)->group(function()
    {
        Route::get('/dapur', 'index');
    });

    Route::controller(SerbagunaController::class)->group(function()
    {
        Route::get('/serbaguna', 'index');
    });

    Route::controller(ReportController::class)->group(function()
    {
        Route::get('/report', 'index');
        Route::put("/report/{report_id}", 'selesai');
    });

    Route::controller(TheatreController::class)->group(function()
    {
        Route::get('/theatre', 'index');
    });
    Route::controller(PenghuniController::class)->group(function(){
        Route::get("/penghuni", 'index');
        Route::post("/penghuni", 'create');
        Route::put("/penghuni/{NIP}", 'update');
        Route::delete("/penghuni/{NIP}", 'destroy');
        Route::get('/search', 'search')->name('search');
        Route::get('/pagination/paginate-data', 'search');
    });
});

Route::prefix('/penghuni')->middleware([MemberMiddleware::class])->group(function(){
    Route::get('/{tes}', [UserController::class, 'errorRoute'])
        ->where('tes', '^(?!mesincuci|coworking|dapur|history|serbaguna|report|theatre|forum).*$');
    Route::controller(ForumController::class)->group(function(){
        Route::get("/forum",'index');
        Route::post("/forum/send-msg",'sendMessage');
    });
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

    Route::controller(SerbagunaController::class)->group(function(){
        Route::get('/serbaguna', 'index');
        Route::post('/serbaguna', 'book');
    });
    Route::controller(ReportController::class)->group(function(){
        Route::get("/report", 'index');
        Route::post("/report", 'sendReport');
    });
    Route::controller(TheatreController::class)->group(function(){
        Route::get("/theatre", 'index');
        Route::post("/theatre", 'book');
    });
    // Route::controller(UserController::class)->group(function(){
    //     Route::post("/change-password", 'change_password');
    // });

    Route::get('/{any}', [UserController::class, 'viewPass'])
        ->where('any', '^(?!mesincuci|coworking|dapur|history|serbaguna|report|theatre).*$');
   
});


