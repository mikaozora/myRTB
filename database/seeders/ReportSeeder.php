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
            'status_id' => '9ac4c529-54df-40bd-b4ad-5db3381d714b'
        ]);
    }
}
