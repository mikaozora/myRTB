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
            'machine_id' => '9ac4c6c3-9965-4a4d-b029-7b885cf7cdb5',
            'NIP' => '0543',
            'start_time' => '2023-12-01 06:00:00',
            'end_time' => '2023-12-01 08:00:00',
            'photo' => null,
            'status_id' => '9ac4c529-54df-40bd-b4ad-5db3381d714b'
        ]);
    }
}
