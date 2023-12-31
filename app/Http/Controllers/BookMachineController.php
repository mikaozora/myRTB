<?php

namespace App\Http\Controllers;

use App\Models\BookMachine;
use App\Models\Status;
use App\Models\User;
use App\Models\WashingMachine;
use Carbon\Carbon;
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


        // array kosong, nampung date untuk 7 hari kedepan
        $date = [];
        for ($i = 0; $i <= 6; $i++) {

            // ngambil waktu sekarang dan masukin ke CarbonInstance
            $carbonInstance = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDay($i));
            $res = $carbonInstance->format('Y-m-d');
            $date[] = [
                "label" => Carbon::now()->addDay($i)->locale('id_ID')->format('D, d'),
                "value" => $res
            ];

        }

        // minta time dan date ke HTTP
        $TimeReq = $request->get('time');
        $DateReq = $request->get('date');

        // gabungin dua-duanya
        $DateTime = $DateReq . ' ' . $TimeReq;

        // bikin tampungan jam available
        $TimeAvailable = [];

        $TimeNow = Carbon::now()->timezone('Asia/Jakarta')->format('H');
        $DateNow = Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');


        // buat perulangan untuk jam sampai jam 22.00, jeda waktu 2 jam sekali
        for ($i = 0; $i <= 22; $i += 2)
        {

            // ngecek hari
            $isToday = false;
            if ($DateReq == $DateNow)
            {

                $isToday = true;

            }

            // ngasih label dan value waktu masing-masing jam
            if ($isToday)
            {

                // ngecek apakah jamnya sudah lewat atau belum
                if ($i > $TimeNow)
                {
                    // kasih nilai untuk dikembalikan, implement di yang lain jg
                    $TimeAvailable[] =
                    [

                        // str pad parameternya dari i yang kita punya
                        // 2 itu berapa huruf yg dipengem
                        // misalkan cuma 4, nanti tambahin 0 di sisi kiri. jadi 04

                        // ini ada if else condition. Kalau 22 jadiin 00, sisanya normal 2 jam setelah jam yang dipilih
                        // balikin isAvailable true

                        "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . ($i == 22 ? str_pad(0, 2, '0', STR_PAD_LEFT) . '.00' : str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00'),
                        "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "isAvailable" => true

                    ];

                } else
                {

                    // ini kalau jam dah lewat
                    $TimeAvailable[] =
                    [
                        "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . ($i == 22 ? str_pad(0, 2, '0', STR_PAD_LEFT) . '.00' : str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00'),
                        "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                        "isAvailable" => false
                    ];

                }

            } else
            {
                // ini kalau bukan hari ini jadi otomatis pasti true semua karena masih akan datang
                $TimeAvailable[] =
                [
                    "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . ($i == 22 ? str_pad(0, 2, '0', STR_PAD_LEFT) . '.00' : str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00'),
                    "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00',
                    "isAvailable" => true
                ];

            }

        }

        $userNIP = $request->session()->get('NIP');
        $userGender = User::where('NIP', 'like', $userNIP)->first()->gender;

        $MachineBooked = BookMachine::join('washing_machines', 'book_machines.machine_id', '=', 'washing_machines.machine_id')
                         ->where('book_machines.start_time', $DateTime)
                         ->select('book_machines.machine_id')
                         ->get();

        // Washing Machine cowok
        $WashingMachine_M = WashingMachine::skip(0)->take(5)->get(['machine_id', 'name']);
        // dd($WashingMachine_M);
        $MaleMachineAvail = [];
        $idx = 1;

        foreach($WashingMachine_M as $WM)
        {

            $isBooked = false;

            foreach($MachineBooked as $MB)
            {

                // cek apakah sudah di booked atau belum
                if ($WM['machine_id'] == $MB['machine_id'])
                {

                    $isBooked = true; break;

                }



            }

            if ($isBooked)
                {

                    $MaleMachineAvai[] =
                    [

                        "index" => $idx,
                        "machine_id" => $WM['machine_id'],
                        "booked" => true

                    ];

                } else
                {
                    $MaleMachineAvail[] =
                    [

                        "index" => $idx,
                        "machine_id" => $WM['machine_id'],
                        "booked" => false

                    ];
                }
                $idx++;


        }

        // Washing Machine cewek
        $WashingMachine_F = WashingMachine::skip(5)->take(7)->get(['machine_id']);
        $FemaleMachineAvail = [];
        $idx = 1;

        foreach($WashingMachine_F as $WM)
        {

            $isBooked = false;

            foreach($MachineBooked as $MB)
            {

                // cek apakah sudah di booked atau belum
                if ($WM['machine_id'] == $MB['machine_id'])
                {

                    $isBooked = true; break;

                }



            }

            if ($isBooked)
                {

                    $FemaleMachineAvai[] =
                    [

                        "index" => $idx,
                        "machine_id" => $WM['machine_id'],
                        "booked" => true

                    ];

                } else
                {
                    $FemaleMachineAvail[] =
                    [

                        "index" => $idx,
                        "machine_id" => $WM['machine_id'],
                        "booked" => false

                    ];
                }
                $idx++;


        }


        // dd($FemaleMachineAvail);
        return response()->view('penghuni.mesincuci', [
            "title" => "Booking Mesin Cuci",
            "datenow" => $date,
            "timeAvail" => $TimeAvailable,
            "userGender" => $userGender,
            "MaleMachine" => $MaleMachineAvail,
            "FemaleMachine" => $FemaleMachineAvail
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function bookMesinCuci(Request $request)
    {

        // mostly minta ke blade inputannya
        $Date = $request->get('date'); //minta date
        $StartTime = $request->input('opt-time');

        // nambahin dua jam dari start time sebagai waktu akhir
        $timeTemp = Carbon::today()->setTimeFromTimeString($StartTime);
        $timeTemp->addHour(2);
        $timeTemp = explode(' ', $timeTemp);
        $EndTime = $timeTemp[1];

        $StartTime = $Date . ' ' . $StartTime;
        $EndTime = $Date . ' ' . $EndTime;

        $machine_id = $request->input('machine');

        // ini ngecek status harusnya
        $status = Status::query()->where('name', '=', 'Booked')->get('status_id');
        $status = json_decode($status, true);
        $statusId = $status[0]['status_id'];

        $NIP = $request->session()->get('NIP');

        // ini kalau dia gk milih mesin, wajib isi
        if(empty($machine_id)){
            return redirect()->action([BookMachine::class, 'index'])->with([
                "message" => 'Wajib memilih mesin cuci',
                "status" => 'error'
            ]);
        }

        // save new data
        $bookMachine = new BookMachine();
        $bookMachine->NIP = $NIP;
        $bookMachine->machine_id = $machine_id;
        $bookMachine->start_time = $StartTime;
        $bookMachine->end_time = $EndTime;
        $bookMachine->status_id = $statusId;
        $bookMachine->save();

        return redirect()->action([BookMachineController::class, 'index'])->with('message', 'Berhasil melakukan booking');

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
