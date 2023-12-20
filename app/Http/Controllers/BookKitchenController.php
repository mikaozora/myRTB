<?php

namespace App\Http\Controllers;

use App\Models\BookKitchen;
use App\Models\KitchenStuff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class BookKitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->is('dashboard/*')) {
            return response()->view('dashboard.dapur', [
                "title" => "Booking Dapur"
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
        $timeAvail = [];
        for ($i = 0; $i <= 22; $i += 2) {
            if ($i == 22) {
                $timeAvail[] = [
                    "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . str_pad(0, 2, '0', STR_PAD_LEFT) . '.00',
                    "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00'
                ];
            }
            $timeAvail[] = [
                "label" => str_pad($i, 2, '0', STR_PAD_LEFT) . '.00 - ' . str_pad($i + 2, 2, '0', STR_PAD_LEFT) . '.00',
                "value" => str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00'
            ];
        }

        $timeParam = $request->get('time');
        $dateParam = $request->get('date');
        $datetime = $dateParam . ' ' . $timeParam;

        $stuffBooked = BookKitchen::join('kitchen_stuffs', 'book_kitchens.stuff_id', '=', 'kitchen_stuffs.stuff_id')
            ->where('book_kitchens.start_time', $datetime)
            ->select('book_kitchens.stuff_id') // Select the columns you need
            ->get();

        $stoves = KitchenStuff::where('name', 'like', 'Stove%')->get('stuff_id');

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
        return response()->view('penghuni.dapur', [
            "title" => "Booking Dapur",
            "datenow" => $date,
            "timeAvail" => $timeAvail,
            "stoveAvailLeft" => $stoveAvailLeft,
            "stoveAvailRight" => $stoveAvailRight,
            "riceCookerAvail" => $riceCookerAvail,
            "airFryerAvail" => $airFryerAvail
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $date = $request->get('date');
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
    public function show(BookKitchen $bookKitchen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookKitchen $bookKitchen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookKitchen $bookKitchen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookKitchen $bookKitchen)
    {
        //
    }
}
