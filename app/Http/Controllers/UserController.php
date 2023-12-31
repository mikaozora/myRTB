<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("sesi/login");
    }

    public function login(Request $request){
        $NIP = $request->input('NIP');
        $password = $request->input('password');
        if(empty($NIP)||empty($password)){
            return response()->view('sesi.login', [
                "error"=>"NIP or Password is required"
            ]);
        }
        $user = User::query()->where('NIP','=',$NIP)->get();

        if(empty($user->first()->NIP)){
            return response()->view('sesi.login', [
                "error"=>"Invalid NIP or Password"
            ]);
        }

        if(empty($user->first()->password)){
            return response()->view('sesi.login', [
                "error"=>"Invalid NIP or Password"
            ]);
        }
        $correctPass = $user->first()->password;

        if(Hash::check($password, $correctPass)){
            $request->session()->put("NIP", $user[0]->NIP);
            return redirect("/");
        }

        return response()->view("sesi.login",[
            "error"=>"Invalid NIP or Password"
        ]);
    }

    public function logout(Request $request){
        $request->session()->forget('NIP');
        return redirect("/");
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
