<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Traits\ToStringFormat;
use DateTimeZone;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response as FacadesResponse;

class RoomController extends Controller
{

    public function index(){
        $date = [];
        for($i = 0; $i <= 6; $i++){
            $date[$i] = Carbon::now()->addDay($i)->locale('id_ID')->format('D, d');
        }

        $now = Carbon::now()->locale('id_ID')->format('D, d');
        // $startTime = Carbon::now(new DateTimeZone('Asia/Jakarta'))->startOfHour()->format('H.00');

        return response()->view('penghuni.coworking', [
            "today" => $now,
            "datenow" => $date,
            "title" => "Booking Co-working Space",
        ]);   
    }
}