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

use function PHPUnit\Framework\isNull;

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

        $timeFrom = [];
        for ($i = 6; $i <= 23; $i++) {
            $timeFrom[] = [
                "label" => $i . ':00',
                "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                "allval" => $request->get('date') . ' ' . str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
            ];            
        }

        // $timeTo = [];
        // for ($i = 7; $i <= 24; $i++) {
        //     $timeTo[] = [
        //         "label" => $i . ':00',
        //         "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //     ];
        // }

        $timeParam = $request->get('fromtime');
        $dateParam = $request->get('date');
        $datetime = $dateParam . ' ' . $timeParam;

        $room = Room::query()->where('name', '=', 'Co-working Space')->get('room_id');
        $decode = json_decode($room, true);
        $room_id = $decode[0]['room_id'];

        $today = $request->get('date');
        $bookCWS = BookRoom::where('room_id', $room_id)
        ->where('start_time', 'like', $today.'%')
        ->get();

        $roomAvail = [];
        // 1.
        // foreach($timeFrom as $tf){
        //     $isBooked = false;
        //     if (empty($bookCWS)){
        //         $roomAvail[] = [
        //             "label" => $tf['label'],
        //             "value" => $tf['value'],
        //             "booked" => false                        
        //         ];
        //     } else {
        //         // foreach($bookCWS as $bc){
        //         //     if ($tf['allval'] == $bc['start_time']){
        //         //         $isBooked = true;
        //         //         break;
        //         //     }
        //         // }
        //         for ($i = 0; $i < sizeof($bookCWS); $i++){
        //             if ($tf['allval'] == $bookCWS[$i]['start_time']) {
        //                 $isBooked = true;

        //                 break;
        //             }
        //         }

        //         if ($isBooked){
        //             $roomAvail[] = [
        //                 'booked' => true,
        //                 'value' => $tf['allval'],
        //                 'label' => $tf['label']
        //             ];
        //         } else {
        //             $roomAvail[] = [
        //                 'booked' => false,
        //                 'value' => $tf['allval'],
        //                 'label' => $tf['label']
        //             ];
        //         }
        //     }
        // }

        // 2.
        for($j = 0; $j < sizeof($timeFrom); $j++){
            $isBooked = false;
            if (empty($bookCWS)){
                $roomAvail[] = [
                    "label" => $timeFrom[$j]['label'],
                    "value" => $timeFrom[$j]['value'],
                    "booked" => false                        
                ];
            } else {
                for ($i = 0; $i < sizeof($bookCWS); $i++){
                    if ($timeFrom[$j]['allval'] == $bookCWS[$i]['start_time']) {
                        $isBooked = true;
                        $startBook = substr($bookCWS[$i]['start_time'], 11, 2);
                        $endBook = substr($bookCWS[$i]['end_time'], 11, 2);
                        if ($endBook - $startBook == 2){
                            $roomAvail[$j] = [
                                'booked' => true,
                                'value' => $timeFrom[$j]['allval'],
                                'label' => $timeFrom[$j]['label']
                            ];
                            $j++;
                        }
                    }
                }
                
                if ($isBooked){
                    $roomAvail[$j] = [
                        'booked' => true,
                        'value' => $timeFrom[$j]['allval'],
                        'label' => $timeFrom[$j]['label']
                    ];
                } else {
                    $roomAvail[$j] = [
                        'booked' => false,
                        'value' => $timeFrom[$j]['allval'],
                        'label' => $timeFrom[$j]['label']
                    ];
                }
            }
        }

        // 3.
        // $count = 0;
        // for($j = 0; $j < sizeof($timeFrom); $j++){
        //     $count++;
        //     $isBooked = false;
        //     if ($count < 24 & $count > 6){
        //         if (empty($bookCWS)){
        //             $roomAvail[] = [
        //                 "label" => $timeFrom[$j]['label'],
        //                 "value" => $timeFrom[$j]['value'],
        //                 "booked" => false,
        //                 'show' => true
        //             ];
        //         } else {
        //             for ($i = 0; $i < sizeof($bookCWS); $i++){
        //                 if ($timeFrom[$j]['allval'] == $bookCWS[$i]['start_time']) {
        //                     $isBooked = true;
        //                     $startBook = substr($bookCWS[$i]['start_time'], 11, 2);
        //                     $endBook = substr($bookCWS[$i]['end_time'], 11, 2);
        //                     if ($endBook - $startBook == 2){
        //                         $roomAvail[$j] = [
        //                             'booked' => true,
        //                             'value' => $timeFrom[$j]['allval'],
        //                             'label' => $timeFrom[$j]['label'],
        //                             'show' => true
        //                         ];
        //                         $j++;
        //                     }
        //                 }
        //             }
                    
        //             if ($isBooked){ 
        //                 $roomAvail[$j] = [
        //                     'booked' => true,
        //                     'value' => $timeFrom[$j]['allval'],
        //                     'label' => $timeFrom[$j]['label'],
        //                     'show' => true
        //                 ];
        //             } else {
        //                 $roomAvail[$j] = [
        //                     'booked' => false,
        //                     'value' => $timeFrom[$j]['allval'],
        //                     'label' => $timeFrom[$j]['label'],
        //                     'show' => true
        //                 ];
        //             }
        //         }
        //     } else {
        //         $roomAvail[$j] = [
        //             'booked' => null,
        //             'value' => null,
        //             'label' => null,
        //             'show' => false
        //         ];
        //     }
        // }

        // 1
        // $timeTo = [];
        // $fromChosen = $request->get('fromtime');
        // if (empty($fromChosen) || $fromChosen == "PilihJam"){
        // } else {
        //     $fromChosen = $request->get('fromtime');
        //     $hour = substr($fromChosen, 11, 2); 
        //     foreach($roomAvail as $ra){
        //         $idx = 0;
        //         for($i = 1; $i <= 2; $i++){
        //             $idx++;
        //             // $hour + $i . ':00'
        //             if ($idx == 2){
        //                 $timeTo[$i] = [
        //                     "label" => $hour + $i . ':00',
        //                     "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                     "booked" => false,
        //                     "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //                 ];
        //                 if ($ra['value'] == $timeTo[$i]['allval'] && $ra['booked'] == true){
        //                     $timeTo[$i] = [
        //                         "label" => $hour + $i . ':00',
        //                         "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                         "booked" => true,
        //                         "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //                     ];
        //                 } 
        //                 // else {
        //                 //     $timeTo[$i] = [
        //                 //         "label" => $hour + $i . ':00',
        //                 //         "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                 //         "booked" => false,
        //                 //         "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //                 //     ];
        //                 // }
        //                 // dd($timeTo);
        //             } else {
        //                 $timeTo[$i] = [
        //                     "label" => $hour + $i . ':00',
        //                     "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                     "booked" => false,
        //                     "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //                 ];
        //             }
        //         }
        //     }
        // }

        $roomAlrBooked = [];
        foreach ($roomAvail as $ra){
            if ($ra['booked'] == true){
                $roomAlrBooked[] = $ra;
            }
        }

        // 2
        // $timeTo = [];
        // $fromChosen = $request->get('fromtime');
        // if (empty($fromChosen) || $fromChosen == "PilihJam"){
        // } else {
        //     $fromChosen = $request->get('fromtime');
        //     $hour = substr($fromChosen, 11, 2); 
        //     if (sizeof($roomAlrBooked) == 0){
        //         for($i = 1; $i <= 2; $i++){
        //             $timeTo[$i] = [
        //                 "label" => $hour + $i . ':00',
        //                 "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                 "booked" => false,
        //                 "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //             ];
        //         }
        //     } 

        //     for($j = 0; $j < 47; $j++){
        //         for($i = 1; $i <= 2; $i++){
        //             $timeTo[$i] = [
        //                 "label" => $hour + $i . ':00',
        //                 "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                 "booked" => false,
        //                 "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //             ];
    
        //             $tempFromChosen = substr($fromChosen, 11, 2); 
        //             $tempTT = substr($timeTo[$i]['allval'], 11, 2); 
                    
        //             if ($tempTT - 2 == $tempFromChosen && $roomAvail[$j+1]['booked'] == false && $roomAvail[$j+2]['booked'] == false){
        //                 $i++;
        //                 $timeTo[$i] = [
        //                     "label" => $hour + $i . ':00',
        //                     "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                     "booked" => false,
        //                     "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //                 ];
        //                 $j = sizeof($roomAvail)-1; 
        //             }

        //             if ($tempTT - 2 == $tempFromChosen && $roomAvail[$j]['value'] == $timeTo[$i]['allval']){
        //                 $timeTo[$i] = [
        //                     "label" => $hour + $i . ':00',
        //                     "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
        //                     "booked" => true,
        //                     "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
        //                 ];
        //                 $j = sizeof($roomAvail); 
        //             }

        //         }
        //     }
        // }

        // 3
        $timeTo = [];
        $fromChosen = $request->get('fromtime');
        if (empty($fromChosen) || $fromChosen == "PilihJam"){
        } else {
            $fromChosen = $request->get('fromtime');
            $hour = substr($fromChosen, 11, 2); 
            if (sizeof($roomAlrBooked) == 0){
                for($i = 1; $i <= 2; $i++){
                    $timeTo[$i] = [
                        "label" => $hour + $i . ':00',
                        "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "booked" => false,
                        "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                    ];
                }
            } 
            for($j = 0; $j < sizeof($roomAlrBooked); $j++){
                for($i = 1; $i <= 2; $i++){
                    $timeTo[$i] = [
                        "label" => $hour + $i . ':00',
                        "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "booked" => false,
                        "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                    ];

                    $tempFromChosen = substr($fromChosen, 11, 2); 
                    $tempTT = substr($timeTo[$i]['allval'], 11, 2); 
                    // $startHour =
                    // bandingin start sma end time buat yg booking 1 jam 
                    
                    if ($tempTT - 2 == $tempFromChosen && $roomAlrBooked[$j]['value'] == $timeTo[$i]['allval']){
                        $timeTo[$i] = [
                            "label" => $hour + $i . ':00',
                            "value" => str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00',
                            "booked" => true,
                            "allval" => $request->get('date') . ' ' . str_pad($hour + $i, 2, '0', STR_PAD_LEFT) . ':00:00'
                        ];
                        $j = sizeof($roomAlrBooked); 
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

        return response()->view('penghuni.coworking', [
            "datenow" => $date,
            "title" => "Booking Co-working Space",
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            "roomAvail" => $roomAvail,
            "books" => $userBooks
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

        $date = $request->get('date');
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
        $book->save();

        return redirect()->action([RoomController::class, 'index'])->with(
            'message', 'Berhasil Melakukan Booking Co-working Space'
        );
    }
}