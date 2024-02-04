<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\BookRoom;
use App\Models\Room;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class SerbagunaController extends Controller
{
    public function index(Request $request){

        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        if($request->is('dashboard/*')){

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

            $serbagunaList = [];

            $BookedSerbaguna = BookRoom::join('status', 'book_rooms.status_id', '=', 'status.status_id')
                             ->join('users', 'book_rooms.NIP', '=', 'users.NIP')
                             ->join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
                             ->where('status.name', '=', $status)
                             ->where(function ($query) {
                                $query->where('rooms.name', '=', 'Serbaguna 1')
                                    ->orWhere('rooms.name', '=', 'Serbaguna 2');
                             })
                             ->select(
                                'book_rooms.*',
                                'users.name as user_name',
                                'rooms.name as room_name',
                                'users.class as user_class'
                             )
                             ->get();


            foreach($BookedSerbaguna as $BS)
            {
                $start_time = explode(' ', $BS->start_time);
                $start_time = substr($start_time[1], 0, 2);
                $end_time = explode(' ', $BS->end_time);
                $end_time = substr($end_time[1], 0, 2);

                $date = Carbon::parse($BS->start_time)->locale('id');
                $date->settings(['formatFunction'=>'translatedFormat']);

                $finalDate = $date->format('l, j F Y');

                $viewStatus = $status;

                if($viewStatus == 'Done')
                {
                    $viewStatus = 'Selesai';
                }

                $serbagunaList[] =
                [
                    "user_name" => $BS->user_name,
                    "room_name" => $BS->room_name,
                    "date" => $finalDate,
                    "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                    "id" => $BS->book_id,
                    "user_class" => $BS->user_class,
                    "status" => $status,
                    "viewStatus" => $viewStatus,
                    "uploadPhoto" => $BS->photo,
                    "is_late" => $BS->is_late
                ];
            }

            // dd($serbagunaList);
            return response()->view('dashboard.serbaguna', [
                "title" => "Booking Ruang Serbaguna",
                "photoProfile" => $photoProfile,
                "serbaguna" => $serbagunaList
            ]);
        }

        $date = [];
        for ($i = 0 ; $i <=6 ; $i++){
            $carbonInstance = Carbon::createFromFormat('Y-m-d H:i:s' , Carbon::now()->addDay($i));
            $res = $carbonInstance->format('Y-m-d');
            $date[] = [
                "label" => Carbon::now()->addDay($i)->locale('id_ID')->format('D,d'),
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

        $rooms = Room::query()->where('name', 'like', 'Serbaguna%')->get('room_id');
        $decode = json_decode($rooms, true);

        $today = $request->get('date');
        $book = BookRoom::query()
        ->where('start_time', 'like', $today.'%')
        ->get();

        $sergunAvail = [];
        $timeNow = Carbon::now()->timezone('Asia/Jakarta')->format('H');
        $dateNow = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        for($i = 0; $i < sizeof($timeFrom); $i++){
            $isBooked = false;
            $start = 0;
            $end = 0;
            if (empty($book)){
                        $sergunAvail[$i] = [
                            "label" => $timeFrom[$i]['label'],
                            "value" => $timeFrom[$i]['value'],
                            "booked" => false,
                            "end" => null
                        ];
            } else if(isset($book)) {
                for ($j = 0; $j < sizeof($book); $j++){
                    if ($timeFrom[$i]['allval'] == $book[$j]['start_time']) {
                        $isBooked = true;
                        $start = substr($book[$j]['start_time'], 11, 2);
                        $end = substr($book[$j]['end_time'], 11, 2);
                        $sergunAvail[$i] = [
                            'booked' => true,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => $book[$j]['end_time'],
                            'isAvailable' => false
                        ];
                    }
                }

                if (!$isBooked){
                        $sergunAvail[$i] = [
                            'booked' => false,
                            'value' => $timeFrom[$i]['allval'],
                            'label' => $timeFrom[$i]['label'],
                            'end' => null,
                            'isAvailable' => true
                        ];
                }
            }
        }

        for ($i = 0; $i < sizeof($sergunAvail) - 1; $i++){
            $start = (int)substr($sergunAvail[$i]['value'], 11, 2);
            $end = (int)substr($sergunAvail[$i]['end'], 11, 2);
            if ($end - $start == 2){
                $sergunAvail[$i+1]['booked'] = true;
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
                    $sergunAvail[$i]["isAvailable"] = true;
                } else{
                    $sergunAvail[$i]["isAvailable"] = false;
                }
            } else {
                $sergunAvail[$i]["isAvailable"] = true;
            }
        }

        $sergunBook = [];
        foreach ($sergunAvail as $ta){
            if ($ta['booked'] == true){
                $sergunBook[] = $ta;
            }
        }

        $timeTo = [];
        $choose = $request->get('fromtime');
        if (empty($choose) || $choose == "PilihJam"){
        } else {
            $choose = $request->get('fromtime');
            $hour = substr($choose, 11, 2);
            if (sizeof($sergunBook) == 0){
                for($i = 1; $i <= 2; $i++){
                    $timeTo[$i] = [
                        "label" => $hour + $i . ':00',
                        "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "booked" => false,
                        "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                    ];
                }
            } else {
                for ($k = 0; $k < sizeof($sergunAvail)-1; $k++){
                    for ($j = 0; $j < sizeof($sergunBook); $j++){
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
                            $tempEndAvail = (int)substr($sergunBook[$j]['end'], 11, 2);
                            $tempAvail = (int)substr($sergunBook[$j]['value'], 11, 2);
                            if ($tempEndAvail - $tempChoose == 2){
                                $timeTo[2] = [
                                    "label" => $hour + 2 . ':00',
                                    "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                    "booked" => true,
                                    "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                                ];
                                $j = sizeof($sergunBook) - 1;
                                $i = 2;
                                $k = sizeof($sergunAvail)-1;
                            } else if ($tempEndAvail - $tempChoose == 3 && $tempAvail - 1 == $tempChoose){
                                $timeTo[2] = [
                                    "label" => $hour + 2 . ':00',
                                    "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                    "booked" => true,
                                    "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                                ];
                                $j = sizeof($sergunBook) - 1;
                                $i = 2;
                                $k = sizeof($sergunAvail)-1;
                            }
                        }
                    }
                }
            }
        }

        $roomSelected = $request->get('sergun');
        $books = BookRoom::join('users', 'book_rooms.NIP', '=', 'users.NIP')
        ->whereDate('book_rooms.start_time', '=', $dateParam)
        ->where('book_rooms.room_id', '=', $roomSelected)
        ->select('users.NIP', 'users.name', 'users.photo', 'users.class', 'book_rooms.start_time', 'book_rooms.end_time', 'book_rooms.room_id')
        ->get();


        $roomBooked = BookRoom::join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
        ->where('book_rooms.start_time', $datetime)
        ->select('book_rooms.room_id')->get();

    //    $sergunAvailLeft = [];

       $idx = 1;
       foreach($rooms as $room){
        $isBooked = false;
        foreach($roomBooked as $b){
            if($room['room_id'] == $b['room_id']){
                $isBooked = true;
                break;
            }
        }
        if($isBooked){
            $sergunAvailLeft[] = [
                "index" => $idx,
                "room_id" => $room['room_id'],
                "booked" => true
            ];
        }else{
            $sergunAvailLeft[] = [
                "index" => $idx,
                "room_id" => $room['room_id'],
                "booked" => false
            ];
        }
        $idx++;
       }
    //    dd($sergunAvailLeft);
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
        // dd($userBooks);

        return response()->view('penghuni.serbaguna', [
            "title" => "Booking Ruang Serbaguna",
            "datenow" => $date,
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            "sergunAvail" => $sergunAvail,
            "sergunAvailLeft" => $sergunAvailLeft,
            "books" => $userBooks,
            "photoProfile" => $photoProfile,
            "rooms" => $rooms
        ]);
    }

    public function book(Request $request){

        $date = $request->get('date');
        $start_time = $request->input('from-time');
        $end_time = $request->input('to-time');
        // $room = Room::query()->where('name', 'like', 'Serbaguna%')->get('room_id');
        // $decode = json_decode($room, true);
        // $room_id = $decode[0]['room_id'];
        $room_id = $request->input('sergun');
        $room_id1 = $request->input('sergun');
        $status = Status::query()->where('name', '=', 'Booked')->get('status_id');
        $decode = json_decode($status, true);
        $status_id = $decode[0]['status_id'];
        $nip = $request->session()->get('NIP');

        if(empty($room_id)){
            return redirect()->action([SerbagunaController::class, 'index'])->with([
                "message" => 'Wajib memilih area Serbaguna',
                "status" => 'error'
            ]);
        }

        $book = new BookRoom();
        $book->NIP = $nip;
        $book->room_id = $room_id;
        $book->room_id = $room_id1;
        $book->status_id = $status_id;
        $book->start_time = $start_time;
        $book->end_time = $end_time;

        $today = Carbon::now()->timezone('Asia/Jakarta');
        $date = substr($today, 8, 2);
        $hour = substr($today, 11, 2);

        $end_banned = BannedUser::where('NIP', '=', $nip)
        ->where('type', '=', 'serbaguna')
        ->select('end_time')
        ->get();

        try{
            $date_banned = substr($end_banned[0]['end_time'], 8, 2);
            $hour_banned = substr($end_banned[0]['end_time'], 11, 2);

            if ($date_banned < $date || $hour_banned < $hour){
                return redirect()->action([SerbagunaController::class, 'index'])->with([
                    'message' => 'Maaf, Anda Terkena Penalti',
                    'status' => 'error'
                ]);
            }
        } catch(Exception $exception){

        }


        $book->save();

        return redirect()->action([SerbagunaController::class, 'index'])->with(
            'message', 'Berhasil Melakukan Booking Serbaguna'
        );
    }
}
