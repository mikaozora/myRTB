<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::query()->create([
            "name" => 'Serbaguna 1'
        ]);
        Room::query()->create([
            "name" => 'Serbaguna 2'
        ]);
        Room::query()->create([
            "name" => 'Co-working Space'
        ]);
        Room::query()->create([
            "name" => 'Theatre'
        ]);
    }
}
