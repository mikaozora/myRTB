<?php

namespace App\Console\Commands;

use App\Models\BookKitchen;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStatusKitchen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-status-kitchen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status Book Kitchen to On Progress';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $status_id = Status::query()->where('name', '=', 'On Progress')->pluck('status_id');
        $status_id = $status_id[0];
        
        $timeNow = Carbon::now()->setTimezone('Asia/Jakarta');
        $dateNow = $timeNow->format('Y-m-d');
        $time = $timeNow->format('H:i');

        BookKitchen::whereRaw("DATE(start_time) = '$dateNow' AND TIME_FORMAT(start_time, '%H:%i') = '$time'")
        ->update(['status_id' => $status_id]);
    }
}
