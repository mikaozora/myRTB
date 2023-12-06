<?php

namespace App\Http\Controllers;

use App\Models\BookMachine;
use Illuminate\Http\Request;

class BookMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->is('dashboard/*')){
            return response()->view('dashboard.mesincuci', [
                "title" => "Booking Mesin Cuci"
            ]);
        }
        return response()->view('penghuni.mesincuci', [
            "title" => "Booking Mesin Cuci"
        ]);
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
    public function show(BookMachine $bookMachine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookMachine $bookMachine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookMachine $bookMachine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookMachine $bookMachine)
    {
        //
    }
}
