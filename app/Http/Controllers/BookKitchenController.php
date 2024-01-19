<?php

namespace App\Http\Controllers;

use App\Models\BookKitchen;
use App\Models\KitchenStuff;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
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
            return response()->view('dashboard.dapur', [
                "title" => "Booking Dapur",
                "photoProfile" => $photoProfile
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
            ->get();
        
        $userBooks = [];
        foreach ($books as $book) {
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

        return response()->view('penghuni.dapur', [
            "title" => "Booking Dapur",
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
        $bookKitchen->save();

        return redirect()->action([BookKitchenController::class, 'index'])->with('message', 'Berhasil melakukan booking');
    }
}
