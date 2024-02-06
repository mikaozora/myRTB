<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\BookRoom;
use App\Models\Room;
use App\Models\Status;
use App\Models\User;
use Carbon\Traits\ToStringFormat;
use DateTimeZone;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response as FacadesResponse;

use function PHPUnit\Framework\isNull;

class RoomController extends Controller
{

    public function nameTwoWords(string $name)
    {
        $stringAwal = $name;
        $arrayKata = explode(' ', $stringAwal);
        if (isset($arrayKata[2]) && strlen($arrayKata[2]) > 0) {
            $arrayKata[2] = substr($arrayKata[2], 0, 1);
        }
        $duaKata = array_slice($arrayKata, 0, 3);
        $stringBaru = implode(' ', $duaKata) . '.';
        return $stringBaru;
    }
    public function index(Request $request)
    {

        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        if ($request->is('dashboard/*')) {
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

            $coworkingList = [];

            $BookedCoworking = BookRoom::join('status', 'book_rooms.status_id', '=', 'status.status_id')
                             ->join('users', 'book_rooms.NIP', '=', 'users.NIP')
                             ->join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
                             ->where('status.name', '=', $status)
                             ->where('rooms.name', '=', 'Co-working Space')
                             ->select(
                                'book_rooms.*',
                                'users.name as user_name',
                                'rooms.name as room_name',
                                'users.class as user_class'
                             )
                             ->get();

            foreach($BookedCoworking as $BC)
            {
                $start_time = explode(' ', $BC->start_time);
                $start_time = substr($start_time[1], 0, 2);
                $end_time = explode(' ', $BC->end_time);
                $end_time = substr($end_time[1], 0, 2);

                $date = Carbon::parse($BC->start_time)->locale('id');
                $date->settings(['formatFunction'=>'translatedFormat']);

                $finalDate = $date->format('l, j F Y');

                $viewStatus = $status;

                if($viewStatus == 'Done')
                {
                    $viewStatus = 'Selesai';
                }

                $coworkingList[] =
                [
                    "user_name" => $BC->user_name,
                    "room_name" => $BC->room_name,
                    "date" => $finalDate,
                    "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                    "id" => $BC->book_id,
                    "user_class" => $BC->user_class,
                    "status" => $status,
                    "viewStatus" => $viewStatus,
                    "uploadPhoto" => $BC->photo,
                    "is_late" => $BC->is_late,
                    "type" => $BC->type
                ];
            }

            // dd($coworkingList);
            return response()->view('dashboard.coworking', [
                "title" => "Booking CWS",
                "photoProfile" => $photoProfile,
                "coworking" => $coworkingList
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

        $room = Room::query()->where('name', '=', 'Co-working Space')->get('room_id');
        $decode = json_decode($room, true);
        $room_id = $decode[0]['room_id'];

        $today = $request->get('date');
        $bookCWS = BookRoom::where('room_id', $room_id)
            ->where('start_time', 'like', $today . '%')
            ->get();

        // FROM TIME
        $roomAvail = [];
        $timeNow = Carbon::now()->timezone('Asia/Jakarta')->format('H');
        $dateNow = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        for ($j = 0; $j < sizeof($timeFrom); $j++) {
            $isBooked = false;
            $startBook = 0;
            $endBook = 0;
            if (empty($bookCWS)) {
                $roomAvail[$j] = [
                    "label" => $timeFrom[$j]['label'],
                    "value" => $timeFrom[$j]['value'],
                    "booked" => false,
                    "end" => null
                ];
            } else {
                for ($i = 0; $i < sizeof($bookCWS); $i++) {
                    if ($timeFrom[$j]['allval'] == $bookCWS[$i]['start_time']) {
                        $isBooked = true;
                        $startBook = substr($bookCWS[$i]['start_time'], 11, 2);
                        $endBook = substr($bookCWS[$i]['end_time'], 11, 2);
                        $roomAvail[$j] = [
                            'booked' => true,
                            'value' => $timeFrom[$j]['allval'],
                            'label' => $timeFrom[$j]['label'],
                            'end' => $bookCWS[$i]['end_time'],
                            'isAvailable' => false
                        ];
                    }
                }
                if (!$isBooked) {
                    $roomAvail[$j] = [
                        'booked' => false,
                        'value' => $timeFrom[$j]['allval'],
                        'label' => $timeFrom[$j]['label'],
                        'end' => null,
                        'isAvailable' => true
                    ];
                }
            }
        }

        // DISABLE NEXT HOUR FOR THOSE BOOKING 2 HOURS
        for ($i = 0; $i < sizeof($roomAvail) - 1; $i++) {
            $startBook = (int)substr($roomAvail[$i]['value'], 11, 2);
            $endBook = (int)substr($roomAvail[$i]['end'], 11, 2);
            if ($endBook - $startBook == 2) {
                $roomAvail[$i + 1]['booked'] = true;
            }
        }

        // DISABLE TIME THAT ALREADY PAST
        for ($i = 0; $i < sizeof($timeFrom); $i++) {
            $past = (int)substr($timeFrom[$i]['allval'], 11, 2);
            $isNow = false;
            if ($dateParam == $dateNow) {
                $isNow = true;
            }
            if ($isNow) {
                if ($past > $timeNow) {
                    $roomAvail[$i]["isAvailable"] = true;
                } else {
                    $roomAvail[$i]["isAvailable"] = false;
                }
            } else {
                $roomAvail[$i]["isAvailable"] = true;
            }
        }

        // TO TIME
        $roomAlrBooked = []; // array of booked room on that day
        foreach ($roomAvail as $ra) {
            if ($ra['booked'] == true) {
                $roomAlrBooked[] = $ra;
            }
        }

        $timeTo = [];
        $fromChosen = $request->get('fromtime');
        if (empty($fromChosen) || $fromChosen == "PilihJam") {
        } else {
            $fromChosen = $request->get('fromtime');
            $hour = substr($fromChosen, 11, 2);
            if (sizeof($roomAlrBooked) == 0) {
                for ($i = 1; $i <= 2; $i++) {
                    $timeTo[$i] = [
                        "label" => $hour + $i . ':00',
                        "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "booked" => false,
                        "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                    ];
                }
            } else {
                for ($k = 0; $k < sizeof($roomAvail) - 1; $k++) {
                    for ($j = 0; $j < sizeof($roomAlrBooked); $j++) {
                        for ($i = 1; $i <= 2; $i++) {
                            if ($hour + $i > 23) {
                                break;
                            }
                            $timeTo[$i] = [
                                "label" => $hour + $i . ':00',
                                "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                "booked" => false,
                                "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                            ];

                            $tempFromChosen = (int)substr($fromChosen, 11, 2);
                            $tempEndRAB = (int)substr($roomAlrBooked[$j]['end'], 11, 2);
                            $tempRAB = (int)substr($roomAlrBooked[$j]['value'], 11, 2);

                            if ($tempEndRAB - $tempFromChosen == 2) {
                                $timeTo[2] = [
                                    "label" => $hour + 2 . ':00',
                                    "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                    "booked" => true,
                                    "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                                ];
                                $j = sizeof($roomAlrBooked) - 1;
                                $i = 2;
                                $k = sizeof($roomAvail) - 1;
                            } else if ($tempEndRAB - $tempFromChosen == 3 && $tempRAB - 1 == $tempFromChosen) {
                                $timeTo[2] = [
                                    "label" => $hour + 2 . ':00',
                                    "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                                    "booked" => true,
                                    "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                                ];
                                $j = sizeof($roomAlrBooked) - 1;
                                $i = 2;
                                $k = sizeof($roomAvail) - 1;
                            }
                        }
                    }
                }
            }
        }

        $books = BookRoom::join('users', 'book_rooms.NIP', '=', 'users.NIP')
            ->whereDate('book_rooms.start_time', '=', $dateParam)
            ->where('book_rooms.room_id', '=', $room_id)
            ->select('users.NIP', 'users.name', 'users.photo', 'users.class', 'book_rooms.start_time', 'book_rooms.end_time', 'book_rooms.type')
            ->get();

        $userBooks = [];
        foreach ($books as $book) {
            $tempStartTime = explode(' ', $book->start_time);
            $tempEndTime = explode(' ', $book->end_time);
            $tempStartTime = $tempStartTime[1];
            $tempEndTime = $tempEndTime[1];
            $tempStartTime = str_replace(':00:00', '.00', $tempStartTime);
            $tempEndTime = str_replace(':00:00', '.00', $tempEndTime);
            $tempType = $book->type;

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
                "end_time" => $tempEndTime,
                "type" => $tempType
            ];
        }

        return response()->view('penghuni.coworking', [
            "datenow" => $date,
            "title" => "Booking CWS",
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            "roomAvail" => $roomAvail,
            "books" => $userBooks,
            // "stringBaru" => $stringBaru,
            "photoProfile" => $photoProfile
        ]);
    }

    public function bookCWS(Request $request)
    {

        $nip = $request->session()->get('NIP');
        $room = Room::query()->where('name', '=', 'Co-working Space')->get('room_id');
        $decode = json_decode($room, true);
        $room_id = $decode[0]['room_id'];
        $count = $request->input('count');
        $start_time = $request->input('from-time');
        $end_time = $request->input('to-time');
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
        $book->start_time = $start_time;
        $book->end_time = $end_time;

        $today = Carbon::now()->timezone('Asia/Jakarta');
        $date = substr($today, 8, 2);
        $hour = substr($today, 11, 2);

        $end_banned = BannedUser::where('NIP', '=', $nip)
        ->where('type', '=', 'co-working space')
        ->select('end_time')
        ->get();

        try{
            $date_banned = substr($end_banned[0]['end_time'], 8, 2);
            $hour_banned = substr($end_banned[0]['end_time'], 11, 2);

            if ($date_banned < $date || $hour_banned < $hour){
                return redirect()->action([RoomController::class, 'index'])->with([
                    'message' => 'Maaf, Anda Terkena Penalti',
                    'status' => 'error'
                ]);
            }
        } catch (Exception $exception){

        }


        $book->save();

        return redirect()->action([RoomController::class, 'index'])->with(
            'message',
            'Berhasil Melakukan Booking Co-working Space'
        );
    }
}
