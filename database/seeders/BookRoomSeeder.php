<?php

namespace Database\Seeders;

use App\Models\BookRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookRoom::query()->create([
            'NIP' => '0543',
            'room_id' => '9b3eba27-11f0-4c7c-93c8-6217781260f3',
            'start_time' => '2023-12-01 06:00:00',
            'end_time' => '2023-12-01 08:00:00',
            'photo' => null,
            'status_id' => '9b3eba04-0aa4-4ff0-a8f1-90b09fdb8908',
            'type' => 'Private',
            'participant' => 25
        ]);
    }
}
