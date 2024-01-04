<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SerbagunaController extends Controller
{
    public function index(Request $request){
               
        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        if($request->is('dashboard/*')){
            return response()->view('dashboard.serbaguna', [
                "title" => "Booking Ruang Serbaguna",
                "photoProfile" => $photoProfile
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

        
        $timeParam = $request->get('time');
        $dateParam = $request->get('date');
        $datetime = $dateParam . ' ' . $timeParam;

        $timeAvail = [];
        $timeNow = Carbon::now()->timezone('Asia/Jakarta')->format('H');
        $dateNow = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');

        for ($i = 0; $i <= 22; $i += 2) {
            $isNow = false;
            if ($dateParam == $dateNow) {
                $isNow = true;
            }
            if ($isNow) {
                if ($i > $timeNow) {
                    $timeAvail[] = [
                        "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . ($i == 22 ? str_pad(0, 2, '0', STR_PAD_LEFT) . '.00' : str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00'),
                        "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "isAvailable" => true
                    ];
                } else {
                    $timeAvail[] = [
                        "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . ($i == 22 ? str_pad(0, 2, '0', STR_PAD_LEFT) . '.00' : str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00'),
                        "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "isAvailable" => false
                    ];
                }
            } else {
                $timeAvail[] = [
                    "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . ($i == 22 ? str_pad(0, 2, '0', STR_PAD_LEFT) . '.00' : str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00'),
                    "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                    "isAvailable" => true
                ];
            }
        }

        return response()->view('penghuni.serbaguna', [
            "title" => "Booking Ruang Serbaguna",
            "datenow" => $date,
            "timeAvail" => $timeAvail,
            "photoProfile" => $photoProfile
        ]);
    }
}
