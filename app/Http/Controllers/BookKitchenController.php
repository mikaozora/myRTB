<?php

namespace App\Http\Controllers;

use App\Models\BannedUser;
use App\Models\BookKitchen;
use App\Models\KitchenStuff;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Foreach_;

class BookKitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

            $dapurList = [];

            $BookedDapur = BookKitchen::join('status', 'book_kitchens.status_id', '=', 'status.status_id')
                            ->join('users', 'book_kitchens.NIP', '=', 'users.NIP')
                            ->join('kitchen_stuffs', 'book_kitchens.stuff_id', '=', 'kitchen_stuffs.stuff_id')
                            ->where('status.name', '=', $status)
                            ->select(
                                'book_kitchens.*',
                                'users.name as user_name',
                                'kitchen_stuffs.name as stuff_name',
                                'users.class as user_class'
                             )
                            ->get();

            foreach($BookedDapur as $BD)
            {
                $start_time = explode(' ', $BD->start_time);
                $start_time = substr($start_time[1], 0, 2);
                $end_time = explode(' ', $BD->end_time);
                $end_time = substr($end_time[1], 0, 2);

                $date = Carbon::parse($BD->start_time)->locale('en');
                $date->settings(['formatFunction'=>'translatedFormat']);

                $finalDate = $date->format('l, j F Y');

                $viewStatus = $status;

                if($viewStatus == 'Done')
                {
                    $viewStatus = 'Selesai';
                }

                $dapurList[] =
                [
                    "user_name" => $BD->user_name,
                    "stuff_name" => $BD->stuff_name,
                    "date" => $finalDate,
                    "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                    "id" => $BD->book_id,
                    "user_class" => $BD->user_class,
                    "status" => $status,
                    "viewStatus" => $viewStatus,
                    "uploadPhoto" => $BD->photo,
                    "is_late" => $BD->is_late
                ];
            }
            // dd($BookedDapur);
            return response()->view('dashboard.dapur', [
                "title" => "Kitchen Booking",
                "photoProfile" => $photoProfile,
                "dapur" => $dapurList
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

        $stuffBooked = BookKitchen::join('kitchen_stuffs', 'book_kitchens.stuff_id', '=', 'kitchen_stuffs.stuff_id')
            ->where('book_kitchens.start_time', $datetime)
            ->select('book_kitchens.stuff_id') // Select the columns you need
            ->get();

        $stoves = KitchenStuff::where('name', 'like', 'Stove%')->get(['stuff_id', 'name']);
        $stoveAvailLeft = [];
        $stoveAvailRight = [];

        $idx = 1;
        foreach ($stoves as $stove) {
            $isBooked = false;
            foreach ($stuffBooked as $sb) {
                if ($stove['stuff_id'] == $sb['stuff_id']) {
                    $isBooked = true;
                    break;
                }
            }
            if ($isBooked) {
                if ($idx > 2) {
                    $stoveAvailRight[] = [
                        "index" => $idx,
                        "stuff_id" => $stove['stuff_id'],
                        "booked" => true
                    ];
                } else {
                    $stoveAvailLeft[] = [
                        "index" => $idx,
                        "stuff_id" => $stove['stuff_id'],
                        "booked" => true
                    ];
                }
            } else {
                if ($idx > 2) {
                    $stoveAvailRight[] = [
                        "index" => $idx,
                        "stuff_id" => $stove['stuff_id'],
                        "booked" => false
                    ];
                } else {
                    $stoveAvailLeft[] = [
                        "index" => $idx,
                        "stuff_id" => $stove['stuff_id'],
                        "booked" => false
                    ];
                }
            }
            $idx++;
        }

        $riceCookerAvail = [];
        $riceCookers = KitchenStuff::where('name', 'like', 'Rice%')->get('stuff_id');
        $idx = 1;
        foreach ($riceCookers as $riceCooker) {
            $isBooked = false;
            foreach ($stuffBooked as $sb) {
                if ($riceCooker['stuff_id'] == $sb['stuff_id']) {
                    $isBooked = true;
                    break;
                }
            }
            if ($isBooked) {
                $riceCookerAvail[] = [
                    "index" => $idx,
                    "stuff_id" => $riceCooker['stuff_id'],
                    "booked" => true
                ];
            } else {
                $riceCookerAvail[] = [
                    "index" => $idx,
                    "stuff_id" => $riceCooker['stuff_id'],
                    "booked" => false
                ];
            }
            $idx++;
        }

        $airFryerAvail = [];
        $airFryers = KitchenStuff::where('name', 'like', 'Air%')->get('stuff_id');
        $idx = 1;
        foreach ($airFryers as $airFryer) {
            $isBooked = false;
            foreach ($stuffBooked as $sb) {
                if ($airFryer['stuff_id'] == $sb['stuff_id']) {
                    $isBooked = true;
                    break;
                }
            }
            if ($isBooked) {
                $airFryerAvail[] = [
                    "index" => $idx,
                    "stuff_id" => $airFryer['stuff_id'],
                    "booked" => true
                ];
            } else {
                $airFryerAvail[] = [
                    "index" => $idx,
                    "stuff_id" => $airFryer['stuff_id'],
                    "booked" => false
                ];
            }
            $idx++;
        }

        // get pengguna hari ini
        $stuffSelected = $request->get('stuff');
        $books = BookKitchen::join('users', 'book_kitchens.NIP', '=', 'users.NIP')
            ->whereDate('book_kitchens.start_time', '=', $dateParam)
            ->where('book_kitchens.stuff_id', '=', $stuffSelected)
            ->select('users.NIP', 'users.name', 'users.photo', 'users.class', 'book_kitchens.start_time', 'book_kitchens.end_time') // Select the columns you need
            ->orderBy('book_kitchen.start_time', 'asc')
            ->get();

        $userBooks = [];
        foreach ($books as $book) {
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

        return response()->view('penghuni.dapur', [
            "title" => "Kitchen Booking",
            "datenow" => $date,
            "timeAvail" => $timeAvail,
            "stoveAvailLeft" => $stoveAvailLeft,
            "stoveAvailRight" => $stoveAvailRight,
            "riceCookerAvail" => $riceCookerAvail,
            "airFryerAvail" => $airFryerAvail,
            "stoves" => $stoves,
            "riceCookers" => $riceCookers,
            "airFryers" => $airFryers,
            "books" => $userBooks,
            "photoProfile" => $photoProfile
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $date = $request->get('date');
        $startTime = $request->input('from-time');
        $tempTime = Carbon::today()->setTimeFromTimeString($startTime);
        $tempTime->addHours(2);
        $tempTime = explode(' ', $tempTime);
        $endTime = $tempTime[1];

        $startTime = $date . ' ' . $startTime;
        if($endTime == '00:00:00'){
            $tempDate = Carbon::parse($date);
            $date = $tempDate->addDay();
            $date = explode(' ', $date);
            $date = $date[0];
        }
        $endTime = $date . ' ' . $endTime;

        $stuffId = $request->input('stuff');
        $status = Status::query()->where('name', '=', 'Booked')->get('status_id');
        $status = json_decode($status, true);
        $statusId = $status[0]['status_id'];

        $nip = $request->session()->get('NIP');

        if(empty($stuffId)){
            return redirect()->action([BookKitchenController::class, 'index'])->with([
                "message" => 'Fasilitas wajib diisi',
                "status" => 'error'
            ]);
        }
        $bookKitchen = new BookKitchen();
        $bookKitchen->NIP = $nip;
        $bookKitchen->stuff_id = $stuffId;
        $bookKitchen->start_time = $startTime;
        $bookKitchen->end_time = $endTime;
        $bookKitchen->status_id = $statusId;

        $today = Carbon::now()->timezone('Asia/Jakarta');
        $date = intval(substr($today, 8, 2));
        $hour = intval(substr($today, 11, 2));

        $end_banned = BannedUser::where('NIP', '=', $nip)
        ->where('type', '=', 'kitchen')
        ->select('end_time')
        ->get();

        try{
            $date_banned = intval(substr($end_banned[0]['end_time'], 8, 2));
            $hour_banned = intval(substr($end_banned[0]['end_time'], 11, 2));

            if ($date_banned > $date || $hour_banned > $hour){
                return redirect()->action([BookKitchenController::class, 'index'])->with([
                    'message' => 'Sorry, you are suspended',
                    'status' => 'error'
                ]);
            }
        } catch (Exception $exception){

        }


        $bookKitchen->save();

        return redirect()->action([BookKitchenController::class, 'index'])->with('message', 'Success Booked Kitchen');
    }
}
