<?php

namespace Database\Seeders;

use App\Models\BookMachine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookMachine::query()->create([
            'machine_id' => '9b3eb0de-1069-46f6-87b8-64dbb209309b',
            'NIP' => '0543',
            'start_time' => '2023-12-01 06:00:00',
            'end_time' => '2023-12-01 08:00:00',
            'photo' => null,
            'status_id' => '9b3eba04-0aa4-4ff0-a8f1-90b09fdb8908'
        ]);
    }
}
