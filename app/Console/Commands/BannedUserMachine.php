<?php

namespace App\Console\Commands;

use App\Models\BannedUser;
use App\Models\BookMachine;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BannedUserMachine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:banned-user-machine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert to table Banned_User after 1 hour not send photo for machine';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status_id = Status::query()->where('name', '=', 'On Progress')->orWhere('name', '=', 'Done')->pluck('status_id');
        $statusProgress = $status_id[0];
        $statusDone = $status_id[1];

        $timeNow = Carbon::now()->setTimezone('Asia/Jakarta');
        $dateNow = $timeNow->format('Y-m-d');
        $time = $timeNow->format('H:i');
        $timeParam = $dateNow . ' ' . $time;
        $endTime = $timeNow->addDays(7);


        $users = BookMachine::query()->whereRaw("status_id = '$statusProgress' AND TIMEDIFF('$timeParam', concat(DATE(end_time), ' ', TIME_FORMAT(end_time, '%H:%i'))) = '01:00:00'")->pluck('NIP');

        foreach($users as $user){
            $bannedUser = new BannedUser();
            $bannedUser->NIP = $user;
            $bannedUser->type = 'machine';
            $bannedUser->end_time = $endTime;
            $bannedUser->save();
        }

        BookMachine::whereRaw("status_id = '$statusProgress' AND TIMEDIFF('$timeParam', concat(DATE(end_time), ' ', TIME_FORMAT(end_time, '%H:%i'))) = '01:00:00'")
            ->update([
                'status_id' => $statusDone,
                'is_late' => '1'
            ]);
    }
}
