<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::query()->create([
            'NIP' => '0543',
            'type' => 'Room',
            'description' => 'AC Bocor',
            'photo' => 'photo3.jpg',
            'status_id' => '9b3eba04-0aa4-4ff0-a8f1-90b09fdb8908'
        ]);
    }
}
