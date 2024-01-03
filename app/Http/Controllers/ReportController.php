<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
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
            return response()->view('dashboard.report', [
                "title" => "Report",
                "photoProfile" => $photoProfile
            ]);
        }
        return response()->view('penghuni.report', [
            "title" => "Report",
            "photoProfile" => $photoProfile
        ]);
    }

    public function sendReport(Request $request){
        $nip = $request->session()->get('NIP');
        $type = $request->get('report_type');
        echo $type;
        $description = $request->input('report');
        $file = $request->file('photo');
        $photo = Carbon::now()->getTimestamp() . $file->getClientOriginalName();
        $path = "data";
        $status = Status::query()->where('name', '=', 'On Progress')->get('status_id');
        $decode = json_decode($status, true);
        $status_id = $decode[0]['status_id'];
        if ($file->move($path, $photo)) { 
            try{
                $report = new Report();
                $report->nip = $nip;
                $report->type = $type;
                $report->description = $description;
                $report->photo = $photo;
                $report->status_id = $status_id; 
                $report->save();
                return redirect()->action([ReportController::class, 'index'])->with(
                    "message",
                    "Laporan Diterima!"
                );
            }catch(QueryException $err){
                if ($err->errorInfo[1] == 1062){
                    return redirect()->action([ReportController::class, 'index'])->with([
                        "message" => "Laporan Gagal Dikirim",
                        "status" => "error"
                    ]);
                }else{
                    return redirect()->action([ReportController::class, 'index'])->with([
                        "message" => "Laporan Gagal Dikirim",
                        "status" => "error"
                    ]);
                }
            }
        }
    }
}
