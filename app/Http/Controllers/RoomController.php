<?php

namespace App\Http\Controllers;

use App\Models\BookRoom;
use App\Models\Room;
use App\Models\Status;
use App\Models\User;
use Carbon\Traits\ToStringFormat;
use DateTimeZone;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response as FacadesResponse;

class RoomController extends Controller
{
    public function index(Request $request){
        if($request->is('dashboard/*')){
            return response()->view('dashboard.coworking', [
                "title" => "Booking Co-working Space"
            ]);
        }
        $date = [];
        for ($i = 0; $i <= 6; $i++) {
            $carbonInstance = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDay($i));
            $res = $carbonInstance->format('Y-m-d');
            $date[] = [
                "label" => Carbon::now()->addDay($i)->locale('id_ID')->format('D, d'),
                "value" => $res
            ];
        }

        return response()->view('penghuni.coworking', [
            "datenow" => $date,
            "title" => "Booking Co-working Space",
        ]);   
    }

    public function bookCWS(Request $request){

        $nip = $request->session()->get('NIP');
        $room = Room::query()->where('name', '=', 'Co-working Space')->get('room_id');
        $decode = json_decode($room, true);
        $room_id = $decode[0]['room_id'];

        $count = $request->input('count');
        if ($count < 15){
            return redirect()->action([RoomController::class, 'index'])->with(
                'message', 'Minimum Participant is 15 persons'
            );
        }

        $book_type = $request->get('book_type');
        $status = Status::query()->where('name', '=', 'Booked')->get('status_id');
        $decode = json_decode($status, true);
        $status_id = $decode[0]['status_id'];


        $book = new BookRoom();
        $book->NIP = $nip;
        $book->room_id = $room_id;
        $book->status_id = $status_id;
        $book->participant = $count;
        $book->type = $book_type;
        // $book->start_time = $date;
        // $book->end_time = $date;
        // $book->save();

        // return redirect()->action([RoomController::class, 'index'])->with(
        //     'message', 'Berhasil Melakukan Booking Co-working Space'
        // );
    }
}