<?php

namespace App\Http\Controllers;

use App\Models\BookKitchen;
use App\Models\BookMachine;
use App\Models\BookRoom;
use App\Models\Report;
use App\Models\Status;
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
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                "id" => $bk->book_id,
                "type" => "kitchen",
                "isLate" => $bk->is_late
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
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                "id" => $bk->book_id,
                "type" => "machine",
                "isLate" => $bk->is_late
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
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                "id" => $bk->book_id,
                "type" => "room",
                "isLate" => $bk->is_late
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
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                "id" => $bk->book_id,
                "type" => "room",
                "isLate" => $bk->is_late
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
                "desc" => $start_time . '.00' . ' - ' . $end_time . '.00',
                "id" => $bk->book_id,
                "type" => "room",
                "isLate" => $bk->is_late
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
                "desc" => $bk->description,
                "id" => $bk->report_id,
                "type" => "report",
                "isLate" => null
            ];
        };


        return response()->view('penghuni.history', [
            "title" => "History",
            "photoProfile" => $photoProfile,
            "histories" => $histories
        ]);
    }
    public function uploadPhoto(Request $request, string $id){
        $type = $request->input('type');
        $file = $request->file('photo');
        $newStatus = Status::query()->where('name', '=', 'Done')->pluck('status_id');

        if($type == 'kitchen'){
            $history = BookKitchen::query()->find($id);
        }else if($type == 'machine'){
            $history = BookMachine::find($id);
        }else if($type == 'room'){
            $history = BookRoom::query()->find($id);
        }else{
            $history = Report::query()->find($id);
        }
        // dd($history);
        if(isset($file)){
            $photo = Carbon::now()->getTimestamp() . $file->getClientOriginalName();
            $path = "data";
            if($file->move($path, $photo)){
                $history->fill([
                    "photo" => $photo,
                    "status_id" => $newStatus[0],
                    "is_late" => '0'
                ]);
                
                $history->save();
                return redirect()->action([HistoryController::class, 'index'])->with("message", 'Berhasil mengirim bukti penggunaan');
            }
        }
    }
}
