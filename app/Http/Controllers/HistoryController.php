<?php

namespace App\Http\Controllers;

use App\Models\BookKitchen;
use App\Models\BookMachine;
use App\Models\BookRoom;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request){
               
        $NIP = $request->session()->get('NIP');
        $user = User::query()->find($NIP);
        $photoProfile = $user->photo;

        $status = $request->get('status');
        // dd($status);
        if(!isset($status)){
            $status = 'Booked';
        }
        if($status == 'pemesanan'){
            $status = 'Booked';
        }else if($status == 'proses'){
            $status = 'On Progress';
        }else if($status == 'selesai'){
            $status = 'Done';
        }

        $histories = [];
        $bookKitchens = BookKitchen::query()->join('status', 'book_kitchens.status_id', '=', 'status.status_id')
        ->join('kitchen_stuffs', 'book_kitchens.stuff_id', '=', 'kitchen_stuffs.stuff_id')
        ->where('NIP', '=', $NIP)->where('status.name', '=', $status)->get();
        
        // dd($bookKitchens);
        foreach($bookKitchens as $bk){
            $start_time = explode(' ', $bk->start_time);
            $start_time = substr($start_time[1], 0, 2);
            $end_time = explode(' ', $bk->end_time);
            $end_time = substr($end_time[1], 0, 2);
            
            $date = Carbon::parse($bk->start_time)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
            $formattedDate = $date->format('l, j F Y');

            $histories[] = [
                "title" => "Booking Dapur",
                "label" => $bk->name,
                "date" => $formattedDate,
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00'
            ];
        };

        $bookMachines = BookMachine::query()->join('status', 'book_machines.status_id', '=', 'status.status_id')
        ->join('washing_machines', 'book_machines.machine_id', '=', 'washing_machines.machine_id')
        ->where('NIP', '=', $NIP)->where('status.name', '=', $status)->get();

        foreach($bookMachines as $bk){
            $start_time = explode(' ', $bk->start_time);
            $start_time = substr($start_time[1], 0, 2);
            $end_time = explode(' ', $bk->end_time);
            $end_time = substr($end_time[1], 0, 2);
            
            $date = Carbon::parse($bk->start_time)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
            $formattedDate = $date->format('l, j F Y');

            $histories[] = [
                "title" => "Booking Mesin Cuci",
                "label" => $bk->name,
                "date" => $formattedDate,
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00'
            ];
        };

        $bookCWS = BookRoom::query()->join('status', 'book_rooms.status_id', '=', 'status.status_id')
        ->join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
        ->where('NIP', '=', $NIP)->where('status.name', '=', $status)->where('rooms.name', '=', 'Co-Working Space')->get();

        foreach($bookCWS as $bk){
            $start_time = explode(' ', $bk->start_time);
            $start_time = substr($start_time[1], 0, 2);
            $end_time = explode(' ', $bk->end_time);
            $end_time = substr($end_time[1], 0, 2);
            
            $date = Carbon::parse($bk->start_time)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
            $formattedDate = $date->format('l, j F Y');

            $histories[] = [
                "title" => "Booking Co-Working Space",
                "label" => $bk->participant . ' participant',
                "date" => $formattedDate,
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00'
            ];
        };

        $bookTheater = BookRoom::query()->join('status', 'book_rooms.status_id', '=', 'status.status_id')
        ->join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
        ->where('NIP', '=', $NIP)->where('status.name', '=', $status)->where('rooms.name', '=', 'Theatre')->get();

        foreach($bookTheater as $bk){
            $start_time = explode(' ', $bk->start_time);
            $start_time = substr($start_time[1], 0, 2);
            $end_time = explode(' ', $bk->end_time);
            $end_time = substr($end_time[1], 0, 2);
            
            $date = Carbon::parse($bk->start_time)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
            $formattedDate = $date->format('l, j F Y');

            $histories[] = [
                "title" => "Booking Theatre",
                "label" => $bk->name,
                "date" => $formattedDate,
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00'
            ];
        };

        $bookSergun = BookRoom::query()->join('status', 'book_rooms.status_id', '=', 'status.status_id')
        ->join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
        ->where('NIP', '=', $NIP)->where('status.name', '=', $status)->where('rooms.name', 'like', 'Serba%')->get();

        foreach($bookSergun as $bk){
            $start_time = explode(' ', $bk->start_time);
            $start_time = substr($start_time[1], 0, 2);
            $end_time = explode(' ', $bk->end_time);
            $end_time = substr($end_time[1], 0, 2);
            
            $date = Carbon::parse($bk->start_time)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
            $formattedDate = $date->format('l, j F Y');

            $histories[] = [
                "title" => "Booking Serbaguna",
                "label" => $bk->name,
                "date" => $formattedDate,
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00'
            ];
        };

        $report = Report::query()->join('status', 'reports.status_id', '=', 'status.status_id')
        ->where('NIP', '=', $NIP)->where('status.name', '=', $status)->get();

        foreach($report as $bk){
            
            $date = Carbon::parse($bk->start_time)->locale('id');
            $date->settings(['formatFunction' => 'translatedFormat']);
            $formattedDate = $date->format('l, j F Y');

            $histories[] = [
                "title" => "Laporan Kerusakan",
                "label" => $bk->type == "Room" ? 'Kamar/Cluster' : 'Fasilitas Umum',
                "date" => $formattedDate,
                "desc" => $bk->description
            ];
        };

        return response()->view('penghuni.history', [
            "title" => "History",
            "photoProfile" => $photoProfile,
            "histories" => $histories
        ]);
    }
}
