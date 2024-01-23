<?php

namespace App\Console\Commands;

use App\Models\BannedUser;
use App\Models\BookRoom;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BannedUserCWS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:banned-user-c-w-s';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert to table Banned_User after 1 hour not send photo for book cws';

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


        $users = BookRoom::join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
            ->where('book_rooms.status_id', '=', $statusProgress)
            ->whereRaw("TIMEDIFF('$timeParam', CONCAT(DATE(book_rooms.end_time), ' ', TIME_FORMAT(book_rooms.end_time, '%H:%i'))) = '01:00:00'")
            ->where('rooms.name', 'like', 'Co%')
            ->pluck('book_rooms.NIP');
        info($users);

        foreach ($users as $user) {
            $bannedUser = new BannedUser();
            $bannedUser->NIP = $user;
            $bannedUser->type = 'co-working space';
            $bannedUser->end_time = $endTime;
            $bannedUser->save();
        }

        BookRoom::join('rooms', 'book_rooms.room_id', '=', 'rooms.room_id')
            ->where('book_rooms.status_id', '=', $statusProgress)
            ->whereRaw("TIMEDIFF('$timeParam', CONCAT(DATE(book_rooms.end_time), ' ', TIME_FORMAT(book_rooms.end_time, '%H:%i'))) = '01:00:00'")
            ->where('rooms.name', 'like', 'Co%')
            ->update([
                'book_rooms.status_id' => $statusDone,
                'book_rooms.is_late' => '1'
            ]);
    }
}
