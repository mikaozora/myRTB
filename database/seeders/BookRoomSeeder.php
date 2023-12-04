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
            'room_id' => '9ac4c42e-89e4-41e1-bb2b-a98a38fa2f07',
            'start_time' => '2023-12-01 06:00:00',
            'end_time' => '2023-12-01 08:00:00',
            'photo' => null,
            'status_id' => '9ac4c529-54df-40bd-b4ad-5db3381d714b',
            'type' => 'Private',
            'participant' => 25
        ]);
    }
}
