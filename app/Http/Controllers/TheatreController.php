<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\BookRoom;
use App\Models\Room;
use App\Models\Status;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TheatreController extends Controller
{
    public function index(Request $request){

        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        if($request->is('dashboard/*'))
        {
            // ini untuk tab atas
            $status = $request->get('status');

            if(!isset($status))
            {
                $status = 'Booked';
            }

            if($status == 'pemesanan')
            {
                $status = 'Booked';
            }
            else if($status == 'proses')
            {
                $status = 'On Progress';
            }
            else if($status == 'selesai')
            {
                $status = 'Done';
            }

            $TheatreList = [];

            $BookedTheatre = BookRoom::join('status', 'book_rooms.status_id', '=', 'status.status_id')
                             ->join('users', 'book_rooms.NIP', '=', 'users.NIP')
                             ->join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
                             ->where('status.name', '=', $status)
                             ->where('rooms.name', '=', 'Theatre')
                             ->select(
                                'book_rooms.*',
                                'users.name as user_name',
                                'rooms.name as room_name',
                                'users.class as user_class'
                             )
                             ->get();

            foreach($BookedTheatre as $BT)
            {
                $start_time = explode(' ', $BT->start_time);
                $start_time = substr($start_time[1], 0, 2);
                $end_time = explode(' ', $BT->end_time);
                $end_time = substr($end_time[1], 0, 2);

                $date = Carbon::parse($BT->start_time)->locale('en');
                $date->settings(['formatFunction'=>'translatedFormat']);

                $finalDate = $date->format('l, j F Y');

                $viewStatus = $status;

                if($viewStatus == 'Done')
                {
                    $viewStatus = 'Selesai';
                }

                $TheatreList[] =
                [
                    "user_name" => $BT->user_name,
                    "room_name" => $BT->room_name,
                    "date" => $finalDate,
                    "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                    "id" => $BT->book_id,
                    "user_class" => $BT->user_class,
                    "status" => $status,
                    "viewStatus" => $viewStatus,
                    "uploadPhoto" => $BT->photo,
                    "is_late" => $BT->is_late
                ];
            }
            // dd($TheatreList);
            return response()->view('dashboard.theatre', [
                "title" => "Theatre Booking",
                "photoProfile" => $photoProfile,
                "theatre" => $TheatreList
            ]);
        }

        $date = [];
        for ($i = 0; $i <= 6; $i++) {
            $carbonInstance = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDay($i));
            $res = $carbonInstance->format('Y-m-d');
            $date[] = [
                "label" => Carbon::now()->addDay($i)->timezone('Asia/Jakarta')->format('D, d'),
                "value" => $res
            ];
        }


        $timeFrom = [];
        for ($i = 6; $i <= 21; $i++) {
            $timeFrom[] = [
                "label" => $i . ':00',
                "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                "allval" => $request->get('date') . ' ' . str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
            ];
        }

        $timeParam = $request->get('fromtime');
        $dateParam = $request->get('date');
        $datetime = $dateParam . ' ' . $timeParam;

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
            if (empty($book)){
                        $theatreAvail[$i] = [
                            "label" => $timeFrom[$i]['label'],
                            "value" => $timeFrom[$i]['value'],
                            "booked" => false,
                            "end" => null
                        ];
            } else {
                for ($j = 0; $j < sizeof($book); $j++){
                    if ($timeFrom[$i]['allval'] == $book[$j]['start_time']) {
                        $isBooked = true;
                        $start = substr($book[$j]['start_time'], 11, 2);
                        $end = substr($book[$j]['end_time'], 11, 2);
                        $theatreAvail[$i] = [
                            'booked' => true,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => $book[$j]['end_time'],
                            'isAvailable' => false
                        ];
                    }
                }
                if (!$isBooked){
                        $theatreAvail[$i] = [
                            'booked' => false,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => null,
                            'isAvailable' => true
                        ];
                }
            }
        }

        for ($i = 0; $i < sizeof($theatreAvail)-1; $i++){
            $start = (int)substr($theatreAvail[$i]['value'], 11, 2);
            $end = (int)substr($theatreAvail[$i]['end'], 11, 2);
            if ($end - $start == 2){
                $theatreAvail[$i+1]['booked'] = true;
            }
        }

        for ($i = 0; $i < sizeof($timeFrom); $i++) {
            $past = (int)substr($timeFrom[$i]['allval'], 11, 2);
            $isNow = false;
            if ($dateParam == $dateNow) {
                $isNow = true;
            }
            if ($isNow) {
                if ($past > $timeNow) {
                    $theatreAvail[$i]["isAvailable"] = true;
                } else{
                    $theatreAvail[$i]["isAvailable"] = false;
                }
            } else {
                $theatreAvail[$i]["isAvailable"] = true;
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
                            if ($hour + $i > 23){
                                break;
                            }
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
            $stringAwal = $book['name'];
            $arrayKata = explode(' ', $stringAwal);
            if (isset($arrayKata[2]) && strlen($arrayKata[2]) > 0) {
                $arrayKata[2] = substr($arrayKata[2], 0, 1);
            }
            $arrayKata = array_slice($arrayKata, 0, 3);
            $stringBaru =count($arrayKata) >= 3 ?  implode(' ', $arrayKata) . '.' : implode(' ', $arrayKata);

            $userBooks[] = [
                "name" => $stringBaru,
                "NIP" => $book['NIP'],
                "photo" => $book['photo'],
                "class" => $book['class'],
                'start_time' => $tempStartTime,
                "end_time" => $tempEndTime
            ];
        }

        return response()->view('penghuni.theatre', [
            "datenow" => $date,
            "title" => "Theatre Booking",
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            "theatreAvail" => $theatreAvail,
            "books" => $userBooks,

            "photoProfile" => $photoProfile
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

        $today = Carbon::now()->timezone('Asia/Jakarta');
        $date = intval(substr($today, 8, 2));
        $hour = intval(substr($today, 11, 2));

        $end_banned = BannedUser::where('NIP', '=', $nip)
        ->where('type', '=', 'theater')
        ->select('end_time')
        ->get();

        try{
            $date_banned = intval(substr($end_banned[0]['end_time'], 8, 2));
            $hour_banned = intval(substr($end_banned[0]['end_time'], 11, 2));

            if ($date_banned > $date || $hour_banned > $hour){
                return redirect()->action([TheatreController::class, 'index'])->with([
                    'message' => 'Sorry, you are suspended',
                    'status' => 'error'
                ]);
            }
        } catch (Exception $exception){

        }


        $book->save();

        return redirect()->action([TheatreController::class, 'index'])->with(
            'message', 'Success Booked Theatre'
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
