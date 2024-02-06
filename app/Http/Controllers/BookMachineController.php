<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\BookMachine;
use App\Models\Status;
use App\Models\User;
use App\Models\WashingMachine;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class BookMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;


        if($request->is('dashboard/*')){

            // minta dari link URL
            $status = $request->get('status');

            // kalau di belakang mesin cuci, kosong, ini basenya
            if(!isset($status))
            {
                $status = 'Booked';
            }

            // kalau ada status=pemesanan, kaitin status ke Booked di database
            // dan seterusnya, just like usual
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

            $MachineList = [];

            $MachineBooked = BookMachine::join('status', 'book_machines.status_id', '=', 'status.status_id')
                            ->join('users', 'book_machines.NIP', '=', 'users.NIP')
                            ->join('washing_machines', 'book_machines.machine_id', '=', 'washing_machines.machine_id')
                            ->where('status.name', '=', $status)
                            ->select(
                                'book_machines.*',
                                'users.name as user_name',
                                'washing_machines.name as machine_name',
                                'users.class as user_class'
                            )
                            ->get();


            foreach($MachineBooked as $machine)
            {
                // ini untuk ambil waktunya, cuma jam
                // example: 01, 10, 21 dan lain-lain
                $start_time = explode(' ', $machine->start_time);
                $start_time = substr($start_time[1], 0, 2);
                $end_time = explode(' ', $machine->end_time);
                $end_time = substr($end_time[1], 0, 2);

                //lokalisasi ke Indonesia
                $date = Carbon::parse($machine->start_time)->locale('id');
                $date->settings(['formatFunction'=>'translatedFormat']);
                //mengubah waktu kira-kira ke Senin, 24 Januari 2024

                $finalDate = $date->format('l, j F Y');

                $viewStatus = $status;

                if($viewStatus == 'Done')
                {
                    $viewStatus = 'Selesai';
                }

                // masukin data yang kita punya
                $MachineList[] =
                [
                    "user_name" => $machine->user_name,
                    "machine_name" => $machine->machine_name,
                    "date" => $finalDate,
                    "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                    "id" => $machine->book_id,
                    "user_class" => $machine->user_class,
                    "status" => $status,
                    "viewStatus" => $viewStatus,
                    "uploadPhoto" => $machine->photo,
                    "is_late" => $machine->is_late

                ];
            }

            // dd($MachineList);
            return response()->view('dashboard.mesincuci', [
                "title" => "Booking Mesin Cuci",
                "photoProfile" => $photoProfile,
                "machines" => $MachineList,
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

                    $MaleMachineAvail[] =
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
        $WashingMachine_F = WashingMachine::skip(5)->take(7)->get(['machine_id', 'name']);
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

                    $FemaleMachineAvail[] =
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

        // Minta ID
        $machineSelected_M = $request->get('machine');
        $books_M = BookMachine::join('users', 'book_machines.NIP', '=', 'users.NIP')
                    ->whereDate('book_machines.start_time', '=', $DateReq)
                    ->where('book_machines.machine_id', '=', $machineSelected_M)
                    ->where('users.gender', '=', 'Male')
                    ->select('users.NIP', 'users.name', 'users.photo', 'users.class', 'book_machines.start_time', 'book_machines.end_time')
                    ->get();

        $userBooks_M = [];
        foreach ($books_M as $book)
        {

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

            $userBooks_M[] =
            [

                "name" => $stringBaru,
                "NIP" => $book['NIP'],
                "photo" => $book['photo'],
                "class" => $book['class'],
                "start_time" => $tempStartTime,
                "end_time" => $tempEndTime

            ];


        }

        $machineSelected_F = $request->get('machine');
        $books_F = BookMachine::join('users', 'book_machines.NIP', '=', 'users.NIP')
                    ->whereDate('book_machines.start_time', '=', $DateReq)
                    ->where('book_machines.machine_id', '=', $machineSelected_F)
                    ->where('users.gender', '=', 'Female')
                    ->select('users.NIP', 'users.name', 'users.photo', 'users.class', 'book_machines.start_time', 'book_machines.end_time')
                    ->get();

        $userBooks_F = [];
        foreach ($books_F as $book)
        {

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


            $userBooks_F[] =
            [

                "name" => $stringBaru,
                "NIP" => $book['NIP'],
                "photo" => $book['photo'],
                "class" => $book['class'],
                "start_time" => $tempStartTime,
                "end_time" => $tempEndTime,

            ];
        }


        // dd($books_M);
        return response()->view('penghuni.mesincuci', [
            "title" => "Booking Mesin Cuci",
            "datenow" => $date,
            "timeAvail" => $TimeAvailable,
            "userGender" => $userGender,
            "MaleMachine" => $MaleMachineAvail,
            "FemaleMachine" => $FemaleMachineAvail,
            "photoProfile" => $photoProfile,
            "books_M" => $userBooks_M,
            "books_F" => $userBooks_F
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

        if($EndTime == '00:00:00'){
            $tempDate = Carbon::parse($Date);
            $Date = $tempDate->addDay();
            $Date = explode(' ', $Date);
            $Date = $Date[0];
        }
        $EndTime = $Date . ' ' . $EndTime;

        $machine_id = $request->input('machine');

        // ini ngecek status harusnya
        $status = Status::query()->where('name', '=', 'Booked')->get('status_id');
        $status = json_decode($status, true);
        $statusId = $status[0]['status_id'];

        $NIP = $request->session()->get('NIP');

        // ini kalau dia gk milih mesin, wajib isi
        if(empty($machine_id)){
            return redirect()->action([BookMachineController::class, 'index'])->with([
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

        $today = Carbon::now()->timezone('Asia/Jakarta');
        $date = intval(substr($today, 8, 2));
        $hour = intval(substr($today, 11, 2));

        $end_banned = BannedUser::where('NIP', '=', $NIP)
        ->where('type', '=', 'machine')
        ->select('end_time')
        ->get();

        try{
            $date_banned = intval(substr($end_banned[0]['end_time'], 8, 2));
            $hour_banned = intval(substr($end_banned[0]['end_time'], 11, 2));

            if ($date_banned > $date || $hour_banned > $hour){
                return redirect()->action([BookMachineController::class, 'index'])->with([
                    'message' => 'Maaf, Anda Terkena Penalti',
                    'status' => 'error'
                ]);
            }
        } catch (Exception $exception){

        }

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
