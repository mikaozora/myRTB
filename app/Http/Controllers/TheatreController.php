<?php

namespace App\Http\Controllers;

use App\Models\BookRoom;
use App\Models\Room;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TheatreController extends Controller
{
    public function index(Request $request){

        if($request->is('dashboard/*')){
             return response()->view('dashboard.theatre', [
             "title" => "Booking Theatre"
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


        $timeParam = $request->get('fromtime');
        $dateParam = $request->get('date');
        $datetime = $dateParam . ' ' . $timeParam;

        $timeFrom = [];
        for ($i = 6; $i <= 21; $i++) {
            $timeFrom[] = [
                "label" => $i . ':00',
                "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                "allval" => $request->get('date') . ' ' . str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
            ];            
        }

        $room = Room::query()->where('name', '=', 'Theatre')->get('room_id');
        $decode = json_decode($room, true);
        $room_id = $decode[0]['room_id'];

        $today = $request->get('date');
        $book = BookRoom::where('room_id', $room_id)
        ->where('start_time', 'like', $today.'%')
        ->get();


        $theatreAvail = [];
        $timeNow = Carbon::now()->timezone('Asia/Jakarta')->format('H');
        $dateNow = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        for($i = 0; $i < sizeof($timeFrom); $i++){
            $isBooked = false;
            $start = 0;
            $end = 0;
            $isNow = false;
            $past = (int)substr($timeFrom[$i]['allval'], 11, 2);
            if ($dateParam == $dateNow){
                $isNow = true;
            }
            if (empty($book)){
                if ($isNow){
                
                    if ($past > $timeNow){
                        $theatreAvail[$i] = [
                            "label" => $timeFrom[$i]['label'],
                            "value" => $timeFrom[$i]['value'],
                            "booked" => true,
                            "end" => null
                        ];
                         
                    } else {
                        $theatreAvail[$i] = [
                            "label" => $timeFrom[$i]['label'],
                            "value" => $timeFrom[$i]['value'],
                            "booked" => true,
                            "end" => null
                        ];

                    }
                }
                
            } else {
                for ($j = 0; $j < sizeof($book); $j++){

                    if ($timeFrom[$i]['allval'] == $book[$j]['start_time']) {
                        $isBooked = true;
                        $start = substr($book[$j]['start_time'], 9, 2);
                        $end = substr($book[$j]['end_time'], 11, 2);
                        $theatreAvail[$i] = [
                            'booked' => true,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => $book[$j]['end_time']
                        ];
                    }

                }    
                if (!$isBooked){

                    if ($past > $timeNow){

                        $theatreAvail[$i] = [
                            'booked' => false,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => null
                        ];
                    } else {
                        
                        $theatreAvail[$i] = [
                            'booked' => true,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => null
                        ];
                    }
                }            
            }
        }

        for ($i = 0; $i < sizeof($theatreAvail); $i++){
            $start = (int)substr($theatreAvail[$i]['value'], 9, 2);
            $end = (int)substr($theatreAvail[$i]['end'], 11, 2);
            if ($end - $start == 2){
                $theatreAvail[$i+1]['booked'] = true;
            }
        }

        $theatreBook = [];
        foreach ($theatreAvail as $ta){
            if ($ta['booked'] == true){
                $theatreBook[] = $ta;
            }
        }

        $timeTo = [];
        $choose = $request->get('fromtime');
        if (empty($choose) || $choose == "PilihJam"){
        } else {
            $choose = $request->get('fromtime');
            $hour = substr($choose, 11, 2); 
            if (sizeof($theatreBook) == 0){
                for($i = 1; $i <= 2; $i++){
                    $timeTo[$i] = [
                        "label" => $hour + $i . ':00',
                        "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "booked" => false,
                        "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                    ];
                }
            } else {
                for ($k = 0; $k < sizeof($theatreAvail)-1; $k++){
                    for ($j = 0; $j < sizeof($theatreBook); $j++){
                        for($i = 1; $i <= 2; $i++){
                            $timeTo[$i] = [
                                "label" => $hour + $i . ':00',
                                "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                "booked" => false,
                                "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                            ];
    
                            $tempChoose = (int)substr($choose, 11, 2); 
                            $tempEndAvail = (int)substr($theatreBook[$j]['end'], 11, 2);
                            $tempAvail = (int)substr($theatreBook[$j]['value'], 11, 2);

                            if ($tempEndAvail - $tempChoose == 2){
                                $timeTo[2] = [
                                    "label" => $hour + 2 . ':00',
                                    "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                    "booked" => true,
                                    "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                                ];
                                $j = sizeof($theatreBook)-1; $i = 2; $k = sizeof($theatreAvail)-1;
                            } else if ($tempEndAvail - $tempChoose == 3 && $tempAvail - 1 == $tempChoose){
                                $timeTo[2] = [
                                    "label" => $hour + 2 . ':00',
                                    "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                    "booked" => true,
                                    "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                                ];
                                $j = sizeof($theatreBook)-1; $i = 2; $k = sizeof($theatreAvail)-1;
                            }                       
                        }
                    }
                }
            }
        }


        $books = BookRoom::join('users', 'book_rooms.NIP', '=', 'users.NIP')
        ->whereDate('book_rooms.start_time', '=', $dateParam)
        ->where('book_rooms.room_id', '=', $room_id)
        ->select('users.NIP', 'users.name', 'users.photo', 'users.class', 'book_rooms.start_time', 'book_rooms.end_time')
        ->get();

        $userBooks = [];
        foreach($books as $book){
            $tempStartTime = explode(' ', $book->start_time);
            $tempEndTime = explode(' ', $book->end_time);
            $tempStartTime = $tempStartTime[1];
            $tempEndTime = $tempEndTime[1];
            $tempStartTime = str_replace(':00:00', '.00', $tempStartTime);
            $tempEndTime = str_replace(':00:00', '.00', $tempEndTime);
            $userBooks[] = [
                "name" => $book['name'],
                "NIP" => $book['NIP'],
                "photo" => $book['photo'],
                "class" => $book['class'],
                'start_time' => $tempStartTime,
                "end_time" => $tempEndTime
            ];
        }

        return response()->view('penghuni.theatre', [
            "datenow" => $date,
            "title" => "Booking Theatre",
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            "theatreAvail" => $theatreAvail,
            "books" => $userBooks
        ]);   
    }

    public function book(Request $request){
        
        $date = $request->get('date');
        $start_time = $request->input('from-time');
        $end_time = $request->input('to-time');
        $room = Room::query()->where('name', '=', 'Theatre')->get('room_id');
        $decode = json_decode($room, true);
        $room_id = $decode[0]['room_id'];
        $status = Status::query()->where('name', '=', 'Booked')->get('status_id');
        $decode = json_decode($status, true);
        $status_id = $decode[0]['status_id'];
        $nip = $request->session()->get('NIP');

        $book = new BookRoom();
        $book->NIP = $nip;
        $book->room_id = $room_id;
        $book->status_id = $status_id;
        $book->start_time = $start_time;
        $book->end_time = $end_time;
        $book->save();

        return redirect()->action([TheatreController::class, 'index'])->with(
            'message', 'Berhasil Melakukan Booking Theatre'
        );
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TheatreController $Theatre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TheatreController $Theatre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TheatreController $Theatre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TheatreController $Theatre)
    {
        //
    }


}
