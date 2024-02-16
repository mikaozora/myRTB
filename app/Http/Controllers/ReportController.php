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

            $status = $request->get('status');

            if(!isset($status))
            {
                $status = 'On Progress';
            }

            else if($status == 'proses')
            {
                $status = 'On Progress';
            }
            else if($status == 'selesai')
            {
                $status = 'Done';
            }

            $reportList = [];

            $report = Report::join('status', 'reports.status_id', '=', 'status.status_id')
                      ->join('users', 'reports.NIP', '=', 'users.NIP')
                      ->where('status.name', '=', $status)
                      ->select(
                        'reports.*',
                        'users.name as user_name',
                        'users.class as user_class',
                        'users.room_number as user_room',
                        'admin photo as admin_photo'
                     )
                     ->get();

            // dd($report);
            foreach($report as $R)
            {

                $viewStatus = $status;

                if($viewStatus == 'Done')
                {
                    $viewStatus = 'Done';
                }

                $reportList[] =
                [
                    "user_name" => $R->user_name,
                    "user_class" => $R->user_class,
                    "id" => $R->report_id,
                    "status" => $status,
                    "viewStatus" => $viewStatus,
                    "uploadPhoto" => $R->photo,
                    "description" => $R->description,
                    "user_room" => $R->user_room,
                    "type" => $R->type,
                    "photoAdmin" => $R->admin_photo

                ];


            }

            return response()->view('dashboard.report', [
                "title" => "Report",
                "photoProfile" => $photoProfile,
                "report" => $reportList
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
                    "Report sent!"
                );
            }catch(QueryException $err){
                if ($err->errorInfo[1] == 1062){
                    return redirect()->action([ReportController::class, 'index'])->with([
                        "message" => "Report failed to send!",
                        "status" => "error"
                    ]);
                }else{
                    return redirect()->action([ReportController::class, 'index'])->with([
                        "message" => "Report failed to send!",
                        "status" => "error"
                    ]);
                }
            }
        }
    }

    public function selesai(request $request, string $report_id)
    {
        $file = $request->file('photo');
        $updateStatus = Status::query()
                        ->where('name', '=', 'Done')
                        ->pluck('status_id');

        $report = Report::query()->find($report_id);
        // $report->fill([
        //     "status_id" => $updateStatus[0]
        // ]);
        if(isset($file)){

            $allowedFileTypes = ['jpg', 'jpeg', 'png'];
            $extension = $file->getClientOriginalExtension();

            // if (!in_array($extension, $allowedFileTypes)) {
            //     return redirect()->back()->with('error', 'Hanya file JPG dan PNG yang diizinkan');
            // }

            $photo = Carbon::now()->getTimestamp() . $file->getClientOriginalName();
            $path = "data";
            if($file->move($path, $photo)){
                $report->fill([
                    "admin photo" => $photo,
                    "status_id" => $updateStatus[0],
                ]);

                $report->save();
                return redirect()->action([ReportController::class, 'index'])->with("message", 'Berhasil menyelesaikan laporan');
            }
        }


        // $report->save();
        // return redirect()->action([ReportController::class, 'index'])->with("message", 'Berhasil menyelesaikan laporan');

    }
}
